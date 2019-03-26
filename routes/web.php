<?php

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

$router->group(['prefix' => 'wf'], function () use ($router) {
    $router->get('hello', 'ECMSController@hello');
    $router->get('holidays/{year}', 'ECMSController@holidays');
    //$router->put('count-workdays/{from}/{to}', ['uses' => 'ECMSController@countWorkdays']); // maybe passing it through the url is not best way
    $router->put('count-workdays', 'ECMSController@countWorkdays');
});




$router->group(['prefix' => 'api'], function () use ($router) {

    $router->get('employees', ['uses' => 'EmployeeController@showAllEmployees']);

    $router->get('employees/{id}', ['uses' => 'EmployeeController@showOneEmployee']);

    $router->post('employees', ['uses' => 'EmployeeController@create']);

    $router->put('employees/{id}', ['uses' => 'EmployeeController@update']);

    $router->delete('employees/{id}', ['uses' => 'EmployeeController@delete']);

    // Add a single holiday
    $router->put('employees/{id}/add-one-holiday', ['uses' => 'EmployeeController@addOneHoliday']);

    // Subtract a single holiday
    $router->put('employees/{id}/subtract-one-holiday', ['uses' => 'EmployeeController@subtractOneHoliday']);

    // add many
    // the url should probably not have the actual days to subtract as part of it. it should be part of the body
    $router->put('employees/{id}/add-holidays/{days}', ['uses' => 'EmployeeController@addHolidays']);

    // subtract many
    // the url should probably not have the actual days to subtract as part of it. it should be part of the body
    $router->put('employees/{id}/subtract-holidays/{days}', ['uses' => 'EmployeeController@subtractHolidays']);

    // take dates
    
    // calculate days between dates
    //$router->put('days-between/{startDate}/{endDate}', ['uses' => 'EmployeeController@daysBetween']);
    
    // calculate work days between dates

    // link work days between dates to holidays
    //

});



