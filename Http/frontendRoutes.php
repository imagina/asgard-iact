<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/iact'], function (Router $router) {
    $router->get('{id}/pdf', [
        'as' => 'iacts.act.pdf',
        'uses' => 'PublicController@pdf',
    ]);
});
