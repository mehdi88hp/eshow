<?php

namespace Kaban\Components\Admin\Posts\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GetPostTagsResource extends JsonResource {

    public function toArray( $request ) {
        return $this->name;

        return [
            'text' => $this->name,
            'id'   => $this->id,
        ];
    }
}
