<?php

Route::get('/', function () {
    echo phpinfo();
    return view('welcome');
});
