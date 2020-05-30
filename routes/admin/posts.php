<?php
Route::group( [ 'middleware' => [ 'web' ], 'namespace' => '\Kaban\Components\Admin\Posts\Controllers' ], function () {
    Route::group( [ 'prefix' => 'admin' ], function () {
        Route::group( [ 'prefix' => 'contents', 'as' => 'admin.contents.' ], function () {
            Route::get( '/{link?}', [
                'as'   => 'posts.index',
                'uses' => 'PostsController@index'
            ] )
                 ->where( 'link', '[^.]*' );
        } );
    } );
} );
//Route::get('/{link?}', 'AuthenticationBaseController@showForm')
//    ->where('link', '[^.]*')
//    ->name('auth.form')
//    ->middleware('guest');
