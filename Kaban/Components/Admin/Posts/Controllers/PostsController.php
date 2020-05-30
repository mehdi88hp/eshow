<?php


namespace Kaban\Components\Admin\Posts\Controllers;


use Illuminate\Http\Request;

class PostsController {
    public function index(Request $request ) {
        return view('AdminPosts::index');
        dd(123);
    }
}
