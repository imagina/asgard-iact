<?php

use Illuminate\Routing\Router;

/** @var Router $router */

$router->group(['prefix' => '/iact'], function (Router $router) {

    $router->group(['prefix' => 'acts'], function (Router $router) {

        //Route create
        $router->post('/', [
            'as' => 'api.iact.acts.create',
            'uses' => 'ActApiController@create',
            'middleware' => ['auth:api']
        ]);

        //Route index
        $router->get('/', [
            'as' => 'api.iact.acts.get.items.by',
            'uses' => 'ActApiController@index',
            'middleware' => ['auth:api']
        ]);

        //Route show
        $router->get('/{criteria}', [
            'as' => 'api.iact.acts.get.item',
            'uses' => 'ActApiController@show',
            'middleware' => ['auth:api']
        ]);

        //Route update
        $router->put('/{criteria}', [
            'as' => 'api.iact.acts.update',
            'uses' => 'ActApiController@update',
            'middleware' => ['auth:api']
        ]);

        //Route delete
        $router->delete('/{criteria}', [
            'as' => 'api.iact.acts.delete',
            'uses' => 'ActApiController@delete',
            'middleware' => ['auth:api']
        ]);

    });
    $router->group(['prefix' => 'participants'], function (Router $router) {

        //Route create
        $router->post('/', [
            'as' => 'api.iact.participants.create',
            'uses' => 'ParticipantApiController@create',
            'middleware' => ['auth:api']
        ]);

        //Route index
        $router->get('/', [
            'as' => 'api.iact.participants.get.items.by',
            'uses' => 'ParticipantApiController@index',
            'middleware' => ['auth:api']
        ]);

        //Route show
        $router->get('/{criteria}', [
            'as' => 'api.iact.participants.get.item',
            'uses' => 'ParticipantApiController@show',
            'middleware' => ['auth:api']
        ]);

        //Route update
        $router->put('/{criteria}', [
            'as' => 'api.iact.participants.update',
            'uses' => 'ParticipantApiController@update',
            'middleware' => ['auth:api']
        ]);

        //Route delete
        $router->delete('/{criteria}', [
            'as' => 'api.iact.participants.delete',
            'uses' => 'ParticipantApiController@delete',
            'middleware' => ['auth:api']
        ]);

    });
// append


});
