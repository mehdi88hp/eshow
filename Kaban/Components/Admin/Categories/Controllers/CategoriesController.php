<?php


namespace Kaban\Components\Admin\Categories\Controllers;


use Illuminate\Http\Request;
use Kaban\Components\Admin\Category\Resources\SearchResource;
use Kaban\General\Enums\EPostStatus;
use Kaban\Models\Category;
use Kaban\Models\Post;

class CategoriesController {
    public function index() {
        return view( 'AdminCategories::index' );
    }

    public function search( Request $request ) {


        $posts = Category::where( 'title', 'like', '%' . $request->val . '%' )->paginate( 10 );

        return SearchResource::collection( $posts );
    }

    public function edit( $id ) {
        $post = Post::with( 'tags' )->findOrFail( $id );
        //next create categoty component then back to here
        dd( $post );

        return view( 'AdminPosts::index' );
    }

    public function all() {
        $posts = Post::paginate( 2 );

        return GetAllPostsResource::collection( $posts );
//        return new GetAllPostsResource( $posts );
    }

    public function store( Request $request ) {
        $uid    = auth()->id();
        $item   = Category::create( [
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
