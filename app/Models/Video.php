<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    //region [STATUSES]
    const STATUS_IN_PROCESS = 'IN_PROCESS';
    const STATUS_IN_QUEUE = 'IN_QUEUE';
    const STATUS_RENDERING = 'RENDERING';
    const STATUS_VIDEO_AVAILABLE = 'VIDEO_AVAILABLE';
    const STATUS_ERROR = 'ERROR';
    const STATUS_NOT_EXIST = 'NOT_EXIST';

    const STATUSES = [
        self::STATUS_IN_PROCESS,
        self::STATUS_IN_QUEUE,
        self::STATUS_RENDERING,
        self::STATUS_VIDEO_AVAILABLE,
        self::STATUS_ERROR,
        self::STATUS_NOT_EXIST,
    ];
    //endregion [STATUSES]

    const TYPE_MP4 = 'mp4';
    const TYPE_HLS = 'hls';

    const TYPES = [
        self::TYPE_MP4,
        self::TYPE_HLS,
    ];
}
