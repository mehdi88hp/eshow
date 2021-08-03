<?php

use Kaban\Models\Role;

Route::group( [ 'middleware' => 'role:developer' ], function () {

    Route::get( '/', function () {
        $user = request()->user(); //getting the current logged in user
//    dd( $user );
//    $user = \Kaban\Models\User::find( 2 );
//    dd( $user, $user->hasRole( 'create-tasks' ) ); //will return true, if user has role
//    $user->givePermissionsTo( 'create-tasks' );// will return permission, if not null
//    dd( $user->can( 'create-tasks' ) ); // will return true, if user has permission
//    echo phpinfo();


//    $dev_role = Role::where( 'slug', 'developer' )->first();
//    $user->roles()->attach( $dev_role );

        return view( 'welcome' );
    } );
} );
