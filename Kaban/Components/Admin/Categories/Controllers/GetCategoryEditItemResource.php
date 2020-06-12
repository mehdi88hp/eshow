<?php

namespace Kaban\Components\Admin\Categories\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GetCategoryEditItemResource extends JsonResource {

    public function toArray( $request ) {
//        dd( $this->category->parent );

        return [
            'title'         => $this->title,
            'parent'        => $this->parent->id,
            'categoryItems' => [ [ 'value' => $this->parent->id, 'text' => $this->parent->title ] ],

        ];
    }
}
