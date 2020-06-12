<?php

namespace Kaban\General\Services\Media;


use Illuminate\Support\Facades\Storage;
use Kaban\Core\Enums\EState;
use Kaban\Models\Media;

class MediaService
{
    protected $uploader;

    protected $host;

    public function __construct(Uploader $uploader)
    {
        $this->uploader = $uploader;

        $this->setHost(config('lastsecond.UPLOAD_HOST'));
    }

    public function upload(MediaFile $file)
    {

        return $this->uploader->upload($file);

    }

    public function createMedia(MediaFile $file, $data = null, $user = null)
    {
        $url = $this->host . '/' . trim($file->getFullPath(), '/ \\');

        $user = $user ?: \Auth::user();

        $media = Media::query()->create([
            'name' => array_get($data, 'name', $file->getName()),
            'title' => array_get($data, 'title', $file->getTitle() ?: $file->getName()),
            'description' => array_get($data, 'description', ''),
            'mime_type' => $file->getMimetype(),
            'disk' => $this->uploader->getDisk(),
            'user_id' => $user ? $user->id : null,
            'created_by' => $user ? $user->id : null,
            'updated_by' => $user ? $user->id : null,
            'path' => $file->getPath(),
            'state' => array_get($data, 'state', EState::enabled),
            'url' => $url,
            'approved_at' => array_get($data, 'approved_at', null),
            'old_id' => $data['old_id'] ?? null,
            'ordering' => $data['ordering'] ?? null,
        ]);

        return $media;
    }

    public function attachMedia($media, $mediable = null, $album = null, $tags = [], $data = [])
    {
        if ($mediable) {
            $mediable->media()->attach($media->id, [
                'album' => $album,
                'tags' => json_encode($tags),
                'data' => json_encode($data)
            ]);
        }

    }

    public function syncMedia($media, $mediable = null, $album = null, $tags = [], $data = [])
    {
        if ($mediable) {
            $mediable->media()->sync([
                $media->id => [
                    'album' => $album,
                    'tags' => json_encode($tags),
                    'data' => json_encode($data)
                ]
            ]);
        }
    }

    public function syncWithoutDetachingMedia($media, $mediable = null, $album = null, $tags = [], $data = [])
    {
        if ($mediable) {
            $mediable->media()->syncWithoutDetaching([
                $media->id => [
                    'album' => $album,
                    'tags' => json_encode($tags),
                    'data' => json_encode($data)
                ]
            ]);
        }
    }

    public function removeMedia($media)
    {
        try {

            $status = Storage::disk($media->disk)->delete([
                $media->path . '/' . $media->name,
                $media->thumbnail_full_path
            ]);

            $media->delete();

            return true;

        } catch (\Exception $e) {
            return false;
        }
    }

    public function batchRemoveMedia($media)
    {
        try {
            $status = Storage::disk('sftp')->delete($media->map(function ($item) {
                return [
                    $item->path . '/' . $item->name,
                    $item->thumbnail_full_path
                ];
            })->collapse()->all());

            $deletedIds = $media->pluck('id')->all();

            Media::query()->whereIn('id', $deletedIds)->delete();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function attachTags($media, $tags)
    {
        return $media->tags()->attach($tags);
    }

    /**
     * @param $file
     * @return MediaFile
     */
    public static function fromUploadedFile($file)
    {
        return (new MediaFile())->fromUploadedFile($file);
    }

    public static function fromInstanceFile($file)
    {
        $mediaFile = new MediaFile();
        $mediaFile->fromImageInstance($file);

        return $mediaFile;
    }

    public function getUploader()
    {
        return $this->uploader;
    }

    public function setHost($host)
    {
        $this->host = trim($host, '/ \\');

        return $this;
    }
}