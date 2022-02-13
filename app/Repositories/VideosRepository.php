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

        $videos = auth()->user()->videos->where('status', Video::STATUS_VIDEO_AVAILABLE);

        return $videos->map(function ($video) {
            return [
                'id' => $video->id,
                'name' => $video->data['unique_id'] ?? '',
                'url' => $video->data['output']['video'][0]['links']['url'] ?? ''
            ];
        })->toArray();
    }
}
