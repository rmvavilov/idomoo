<?php

namespace App\Repositories;

use App\Models\Video;

class VideosRepository
{
    public static function getAllVideos(): array
    {
        if (!auth()->user()) {
            return [];
        }

        $videos = auth()->user()->videos
            ->whereIn('status', [
                Video::STATUS_IN_PROCESS,
                Video::STATUS_IN_QUEUE,
                Video::STATUS_RENDERING,
                Video::STATUS_VIDEO_AVAILABLE,
            ]);

        return $videos->map(function ($video) {
            return self::getVideoForFrontend($video);
        })->toArray();
    }

    public static function getVideoForFrontend(Video $video): array
    {
        return [
            'id' => $video->id,
            'name' => $video->data['unique_id'] ?? '',
            'url' => $video->data['output']['video'][0]['links']['url'] ?? '',
            'is_available' => $video->status == Video::STATUS_VIDEO_AVAILABLE,
        ];
    }
}
