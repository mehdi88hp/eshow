<?php
Route::group( [
    'middleware' => [ 'web', 'panel' ],
    'namespace'  => '\Kaban\Components\Admin\Media\Controllers'
], function () {
    Route::group( [ 'prefix' => 'admin' ], function () {
        Route::group( [ 'prefix' => 'contents', 'as' => 'admin.contents.' ], function () {
            Route::get( '/{link?}', [
                'as'   => 'categories.index',
                'uses' => 'CategoriesController@index'
            ] )->where( 'link', '[^.]*' );

            Route::post( '/media/upload', [
                'as'   => 'media.upload',
                'uses' => 'MediaController@upload'
            ] );
        } );
    } );
} );
//Route::get('/{link?}', 'AuthenticationBaseController@showForm')
//    ->where('link', '[^.]*')
//    ->name('auth.form')
//    ->middleware('guest');
