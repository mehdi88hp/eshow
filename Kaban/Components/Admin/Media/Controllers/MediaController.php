<?php


namespace Kaban\Components\Admin\Media\Controllers;


use Illuminate\Support\Facades\Auth;
use Kaban\Components\Site\Reviews\Requests\ReviewMediaUploadRequest;
use Kaban\General\Services\Media\MediaService;

class MediaController {
    public function index() {

    }

    public function upload( ReviewMediaUploadRequest $request ) {
        try {
            $auth = Auth::user();

            $review = $auth->reviews()->findOrFail( $request->input( 'id' ) );

            $reviewable = $review->reviewable;

            if ( count( $review->media ) >= $this->getReviewMaximumImagesCount( $reviewable ) ) {
                throw new Exception( "exceed maximum file number" );
            }
            $mediaFile = MediaService::fromUploadedFile( $request->file( 'image' ) );

            $this->mediaService->getUploader()->setConfigKey( 'review' );
            if ( $this->mediaService->upload( $mediaFile ) ) {
                $oldMedia = ( $oldId = $request->input( 'old_id' ) )
                    ? $review->media()->find( $oldId )
                    : null;
                $data     = $request->only( [ 'description' ] );

                if ( $oldMedia ) {
                    $data = array_merge( $data, [
                        'old_id' => $oldMedia->id,
                    ] );
                }

                $pivotData = [
                    'category_id'     => $request->input( 'category' ),
                    'reviewable_id'   => $reviewable->id,
                    'reviewable_type' => $reviewable->type_name
                ];

                $media = $this->mediaService->createMedia( $mediaFile, $data );

                $this->mediaService->attachMedia( $media, $reviewable, 'reviews', [], array_only( $pivotData, [ 'category_id' ] ) );

                $this->mediaService->attachMedia( $media, $review, null, [], $pivotData );

                if ( $oldMedia && ! $oldMedia->is_approved ) {
                    $this->mediaService->removeMedia( $oldMedia );
                }
            } else {
                throw new Exception( "Cannot upload media" );
            }


            return response()->json( [
                'success' => true,
                'media'   => [
                    'id'          => $media->id,
                    'url'         => $media->url,
                    'category'    => $request->input( 'category' ),
                    'is_approved' => false,
                    'description' => $request->input( 'description' ),
                    'category_id' => $request->input( 'category' ),

                ],
                'message' => trans( 'site.reviews.media.media_uploaded_successfully' ),
            ] );

        } catch ( Exception $e ) {
            return response()->json( [
                'status'  => false,
                'message' => $e->getMessage(),
            ], 400 );
        }
    }
}
