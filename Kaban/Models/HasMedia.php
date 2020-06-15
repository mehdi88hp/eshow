<?php

namespace Kaban\Models;


trait HasMedia
{
    public function media()
    {
        return $this->morphToMany(Media::class, 'mediable', 'mediables')->withPivot('album', 'tags', 'data')->withTimestamps();
    }

    public function getMediableTypeNameAttribute()
    {
        return snake_case(class_basename($this));
    }
}
