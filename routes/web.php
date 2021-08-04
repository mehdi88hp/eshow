<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
//
//$segments = ['admin', 'site'];
//foreach ($segments as $segment) {
//    foreach (scandir(__DIR__ . '/' . $segment) as $file) {
//        if ($file != '.' && $file != '..') {
//            require_once(__DIR__ . '/' . $segment . '/' . $file);
//        }
//    }
//}
//
//Auth::routes();
//
//Route::get('/x', function () {
//    echo phpinfo();
//})->name('home2');
//Route::get('/home', 'HomeController@index')->name('home');
//
////dummy
//Route::get('/roles', 'PermissionController@Permission');
//
//Route::get('/tokens/create', function (Request $request) {
//    $token = $request->user()->createToken('auth_token');
////    $token = $request->user()->createToken($request->token_name);
//
//    return ['token' => $token->plainTextToken];
//});
//
//
//
