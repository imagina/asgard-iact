<?php

namespace Modules\Iact\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterIactSidebar implements \Maatwebsite\Sidebar\SidebarExtender
{
    /**
     * @var Authentication
     */
    protected $auth;

    /**
     * @param Authentication $auth
     *
     * @internal param Guard $guard
     */
    public function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    public function handle(BuildingSidebar $sidebar)
    {
        $sidebar->add($this->extendWith($sidebar->getMenu()));
    }

    /**
     * @param Menu $menu
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {
        $menu->group(trans('core::sidebar.content'), function (Group $group) {
            $group->item(trans('iact::common.iacts'), function (Item $item) {
                $item->icon('fa fa-folder-open-o');
                $item->weight(10);
                $item->authorize(
                    $this->auth->hasAccess('iact.acts.index')
                );
                $item->item(trans('iact::acts.title.acts'), function (Item $item) {
                    $item->icon('fa fa-file-text-o');
                    $item->weight(0);
                    $item->append('admin.iact.act.create');
                    $item->route('admin.iact.act.index');
                    $item->authorize(
                        $this->auth->hasAccess('iact.acts.index')
                    );
                });

            });
        });

        return $menu;
    }
}
