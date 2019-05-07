<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/iact'], function (Router $router) {
    $router->bind('act', function ($id) {
        return app('Modules\Iact\Repositories\ActRepository')->find($id);
    });
    $router->get('acts', [
        'as' => 'admin.iact.act.index',
        'uses' => 'ActController@index',
        'middleware' => 'can:iact.acts.index'
    ]);
    $router->get('acts/create', [
        'as' => 'admin.iact.act.create',
        'uses' => 'ActController@create',
        'middleware' => 'can:iact.acts.create'
    ]);
    $router->post('acts', [
        'as' => 'admin.iact.act.store',
        'uses' => 'ActController@store',
        'middleware' => 'can:iact.acts.create'
    ]);
    $router->get('acts/{act}/edit', [
        'as' => 'admin.iact.act.edit',
        'uses' => 'ActController@edit',
        'middleware' => 'can:iact.acts.edit'
    ]);
    $router->put('acts/{act}', [
        'as' => 'admin.iact.act.update',
        'uses' => 'ActController@update',
        'middleware' => 'can:iact.acts.edit'
    ]);
    $router->delete('acts/{act}', [
        'as' => 'admin.iact.act.destroy',
        'uses' => 'ActController@destroy',
        'middleware' => 'can:iact.acts.destroy'
    ]);
    $router->bind('participants', function ($id) {
        return app('Modules\Iact\Repositories\ParticipantsRepository')->find($id);
    });
    $router->get('participants', [
        'as' => 'admin.iact.participants.index',
        'uses' => 'ParticipantsController@index',
        'middleware' => 'can:iact.participants.index'
    ]);
    $router->get('participants/create', [
        'as' => 'admin.iact.participants.create',
        'uses' => 'ParticipantsController@create',
        'middleware' => 'can:iact.participants.create'
    ]);
    $router->post('participants', [
        'as' => 'admin.iact.participants.store',
        'uses' => 'ParticipantsController@store',
        'middleware' => 'can:iact.participants.create'
    ]);
    $router->get('participants/{participants}/edit', [
        'as' => 'admin.iact.participants.edit',
        'uses' => 'ParticipantsController@edit',
        'middleware' => 'can:iact.participants.edit'
    ]);
    $router->put('participants/{participants}', [
        'as' => 'admin.iact.participants.update',
        'uses' => 'ParticipantsController@update',
        'middleware' => 'can:iact.participants.edit'
    ]);
    $router->delete('participants/{participants}', [
        'as' => 'admin.iact.participants.destroy',
        'uses' => 'ParticipantsController@destroy',
        'middleware' => 'can:iact.participants.destroy'
    ]);
// append


});
