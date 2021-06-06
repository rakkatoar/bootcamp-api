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

$router->get('/', function () use ($router) {
    return $router->app->version();
});
// $router->get("/user", "TestingController@main");
// $router->get("/user/{id}", "TestingController@filter_user");
// $router->post("/user", "TestingController@create_user");
// $router->put("/user/{id}", "TestingController@update_user");
// $router->delete("/user/{id}", "TestingController@delete_user");

$router->get("/userMain", "UserController@main");
$router->get("/user", "UserController@get_all_user");
$router->get("/user/{id}", "UserController@get_filter_user");
$router->get("/user/name/{username}", "UserController@get_filter_user_name");
$router->post("/user", "UserController@create_user");

$router->get("/billing", "BillingController@get_all_billing");
$router->get("/billing/{id}", "BillingController@get_filter_billing");
$router->post("/billing", "BillingController@create_billing");

$router->post("/list", "IndexController@main");
$router->post("/store", "DataController@main");
$router->post("/auth", "AuthController@main");
