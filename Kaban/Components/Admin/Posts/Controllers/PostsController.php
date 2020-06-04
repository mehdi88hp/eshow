<?php


namespace Kaban\Components\Admin\Posts\Controllers;


use Illuminate\Http\Request;
use Kaban\General\Enums\EPostStatus;
use Kaban\Models\Post;

class PostsController {
    public function index( Request $request ) {
        return view( 'AdminPosts::index' );
    }

    public function all() {
        $posts = Post::all();
    }

    public function store( Request $request ) {
        $uid    = auth()->id();
        $item   = Post::create( [
            'content'    => $request->content,
            'title'      => $request->title,
            'excerpt'    => $request->excerpt,
            'author_id'  => $uid,
            'created_by' => $uid,
            'updated_by' => $uid,
            'status'     => EPostStatus::approved,
            'slug'       => slugify( 'title' )
        ] );
        $tagIds = $item->syncTags( $request->input( 'tag', [] ) );

        $item->tag_ids = $tagIds;
        $item->save();
    }
}
