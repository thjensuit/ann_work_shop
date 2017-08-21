<?php

$app->get('/', function () use ($app) {
    return $app->version();
});

$app->group([
    'prefix' => 'v1',
    'namespace' => 'App\Api\V1\Controllers',
], function ($app) {
    // $app->get('resources', 'SampleController@getListAction');
    // $app->post('resources', 'SampleController@postCreateAction');
    // $app->get('resources/{id}', 'SampleController@getInstanceAction');
    // $app->put('resources/{id}', 'SampleController@putUpdateAction');
    // $app->get('resources/{id}', 'SampleController@deleteRemoveAction');
});