<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', ['as' => 'home', 'uses' => 'Controller@home']);

$router->get('/playground', ['as' => 'playground', 'uses' => 'Controller@playgroundReact']);

$router->group(['prefix' => 'api/v1', 'namespace'=>'Api\V1'], function () use ($router) {
    
    $router->group(['prefix' => 'messages'], function () use ($router) {
    
        $router->post('/create',                  ['as' => 'api.messages.receive', 'uses' => 'MessagesController@store']);
        $router->post('/result',                  ['as' => 'api.messages.result',  'uses' => 'MessagesController@storeResult']);
        $router->get( '/status/{transaction_id}', ['as' => 'api.messages.status',  'uses' => 'MessagesController@status']);
        
        
        // should these be also be public?
        // --> no these are for internal use only

        $router->get('/list[/{key_id}]',        ['as' => 'api.messages.list',   'uses' => 'MessagesController@list']);
        $router->get('/send[/{transaction_id}]',    ['as' => 'api.messages.send',   'uses' => 'MessagesController@send']);
        $router->post('/return[/{transaction_id}]', ['as' => 'api.messages.return', 'uses' => 'MessagesController@returnResult']);
        
        
    });

});
