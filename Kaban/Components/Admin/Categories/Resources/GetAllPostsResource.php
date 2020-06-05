<?php

namespace Kaban\Components\Admin\Category\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GetAllPostsResource extends JsonResource {
//class GetAllPostsResource extends ResourceCollection {
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray( $request ) {
//        return [
//            'data' => $this->collection,
//            'links' => [
//                'self' => 'link-value',
//            ],
//        ];
        return [
            'title'   => $this->title,
//            'content' => $this->content,
            'excerpt' => $this->excerpt,
            'id'      => $this->id,

        ];

        return parent::toArray( $request );
    }
}
