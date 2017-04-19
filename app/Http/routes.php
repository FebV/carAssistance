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
define('BASE', '/');
$app->get(BASE.'test',
    function(){
        return "qwe";
    }
);

$app->get(BASE.'', 'UserController@all_user');
$app->post(BASE.'user', 'UserController@new_user');
$app->get(BASE.'logo/{brand}', function($brand){
    try{
        $img = file_get_contents("../resources/logos/$brand.jpg");
    }catch (Exception $e){
        $c = new App\Http\Controllers\Controller;
        return $c->stdResponse(6);
    }
    return response($img)->header('Content-Type', 'image/jpg');
});
$app->get(BASE.'upload', function(){
    return view('upload');
});
$app->get(BASE.'logo', function(Illuminate\Http\Request $request){
    $logo = $request->file('logo');
   if(!($request->hasFile('logo') && $logo->isValid()))
       return '<meta charset="utf-8" />没有图片';

   if(!$request->has('brand'))
       return '<meta charset="utf-8" />没有商标名';

    $brand = $request->input('brand');
    $img = file_get_contents("../resources/logos/bmw.jpg");
    $request->file('logo')->move("../resources/logos/", $brand.'.jpg');
    return '成功了';
});

$app->group(['prefix' => BASE.'user', 'middleware' => 'login', 'namespace' => 'App\Http\Controllers'], function () use ($app) {
    $app->get('/i', 'UserController@user_info');
    $app->get('/i/photo', 'UserController@get_photo');

});


$app->group(['prefix' => BASE.'user/i/car', 'middleware' => 'login', 'namespace' => 'App\Http\Controllers'], function () use ($app) {

    $app->post('', 'CarController@new_car');
    $app->get('', 'CarController@all_car');
    $app->put('/{id}', 'CarController@update_record');
    $app->get('/status', 'CarController@my_car_is_normal');
});

$app->group(['prefix' => BASE.'user/i/order', 'middleware' => 'login', 'namespace' => 'App\Http\Controllers'], function () use ($app) {

    $app->post('', 'OrderController@new_order');
    $app->get('', 'OrderController@all_order');
    $app->get('/{id}/pic', 'OrderController@return_pic');
//    $app->put('/{id}', 'OrderController@update_record');
});


$app->group(['prefix' => BASE.'auth', 'namespace' => 'App\Http\Controllers'], function () use ($app) {

    $app->post('', 'AuthController@login');
});
