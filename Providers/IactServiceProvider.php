<?php

namespace Modules\Iact\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Iact\Events\Handlers\RegisterIactSidebar;

class IactServiceProvider extends ServiceProvider
{
    use CanPublishConfiguration;
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
        $this->app['events']->listen(BuildingSidebar::class, RegisterIactSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('acts', array_dot(trans('iact::acts')));
            $event->load('participants', array_dot(trans('iact::participants')));
            // append translations


        });
    }

    public function boot()
    {
        $this->publishConfig('iact', 'config');
        $this->publishConfig('iact', 'settings');
        $this->publishConfig('iact', 'permissions');

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Iact\Repositories\ActRepository',
            function () {
                $repository = new \Modules\Iact\Repositories\Eloquent\EloquentActRepository(new \Modules\Iact\Entities\Act());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Iact\Repositories\Cache\CacheActDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Iact\Repositories\ParticipantsRepository',
            function () {
                $repository = new \Modules\Iact\Repositories\Eloquent\EloquentParticipantsRepository(new \Modules\Iact\Entities\Participants());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Iact\Repositories\Cache\CacheParticipantsDecorator($repository);
            }
        );
// add bindings


    }
}
