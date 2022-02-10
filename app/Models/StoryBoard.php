<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoryBoard extends Model
{
    use HasFactory;

    protected $fillable = [
        'storyboard_id',
        'name',
        'thumbnail_time',
        'width',
        'height',
        'thumbnail',
        'data',
        'last_modified_at',
    ];

//    protected $casts = [
//        'data' => 'array',
//    ];

}
