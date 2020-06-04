<?php
$segments = [ 'admin', 'site' ];
foreach ( $segments as $segment ) {
    foreach ( scandir( __DIR__ . '/' . $segment ) as $file ) {
        if ( $file != '.' && $file != '..' ) {
            require_once( __DIR__ . '/' . $segment . '/' . $file );
        }
    }
}

Auth::routes();

Route::get( '/home', 'HomeController@index' )->name( 'home' );

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
