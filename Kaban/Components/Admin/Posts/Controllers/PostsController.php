<?php


namespace Kaban\Components\Admin\Posts\Controllers;


use Illuminate\Http\Request;
use Kaban\Components\Admin\Posts\Resources\GetAllPostsResource;
use Kaban\Components\Admin\Posts\Resources\GetPostEditItemResource;
use Kaban\Components\Admin\Posts\Resources\GetSearchedPostsResource;
use Kaban\General\Enums\EPostStatus;
use Kaban\Models\Post;

class PostsController {
    public function index( Request $request ) {
        return view( 'AdminPosts::index' );
    }

    public function edit( $id ) {
        $post = Post::with( 'tags' )->findOrFail( $id );

        return new GetPostEditItemResource( $post );
    }

    public function search() {
        $post = Post::with( 'media' )->paginate( 10 );

        return GetSearchedPostsResource::collection( $post );
    }

    public function all( Request $request ) {
        $sortType = 'DESC';
        $sortBy   = 'id';

        if ( ! empty( $request->sortBy[0] ) && in_array( $request->sortBy[0], [ 'id', 'title' ] ) ) {
            $sortBy = $request->sortBy[0];
        }
        if ( empty( $request->sortDesc[0] ) ) {
            $sortType = 'ASC';
        }

        $posts = Post::when( $request->search, function ( $q ) use ( $request ) {
            $q->where( 'title', 'like', "%$request->search%" );
        } )->orderBy( $sortBy, $sortType )->paginate( $request->itemsPerPage, [ '*' ], 'ascasc', $request->page );

        return GetAllPostsResource::collection( $posts );
//        return new GetAllPostsResource( $posts );
    }

    public function store( Request $request ) {
        $uid    = auth()->id();
        $item   = Post::create( [
            'content'     => $request->input( 'content' ),
            'title'       => $request->title,
            'excerpt'     => $request->excerpt,
            'category_id' => $request->categories,
            'author_id'   => $uid,
            'created_by'  => $uid,
            'updated_by'  => $uid,
            'status'      => EPostStatus::approved,
            'slug'        => slugify( 'title' )
        ] );
        $tagIds = $item->syncTags( $request->input( 'tag', [] ) );

        $item->tag_ids = $tagIds;
        $item->save();
    }

    public function update( Request $request ) {
        $uid  = auth()->id();
        $post = Post::find( $request->id );

        $post->update( [
            'content'     => $request->input( 'content' ),
            'title'       => $request->title,
            'excerpt'     => $request->excerpt,
            'category_id' => $request->categories,
            'author_id'   => $uid,
            'created_by'  => $uid,
            'updated_by'  => $uid,
            'status'      => $request->status['value'],
            'slug'        => slugify( 'title' )
        ] );
        $tagIds = $post->syncTags( $request->tags );

        $post->tag_ids = $tagIds;
        $post->save();

    }

    public function destroy( $id ) {
        $status = Post::findOrFail( $id )->delete();

        return 'done';
    }
}
