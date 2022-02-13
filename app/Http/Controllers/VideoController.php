<?php

namespace App\Http\Controllers;

use App\Helpers\IdomooStoryBoard;
use App\Helpers\IdomooVideo;
use App\Http\Requests\VideoStoreRequest;
use App\Models\StoryBoard;
use App\Models\Video;
use App\Repositories\StoryBoardRepository;
use App\Repositories\VideosRepository;
use http\Client\Curl\User;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'videos' => VideosRepository::getAllVideos(),
        ]);
    }

    public function create()
    {
        try {
            return response()->json([
                'success' => true,
                'data' => StoryBoardRepository::getDataArray(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
            ]);
        }
    }

    public function store(VideoStoreRequest $request)
    {
        $idomooVideo = new IdomooVideo();
        $data = [
            "storyboard_id" => IdomooStoryBoard::DEFAULT_STORY_BOARD_ID,
            "video_file_name" => "testvideo",
            "output" => [
                "video" => [
                    [
                        "video_type" => "mp4",
//                        "quality" => 26,
                        "height" => 1024,
//                        "crop_to_ratio" => [
//                            4,
//                            5
//                        ],
//                        "overlay_scale" => "fit",
//                        "landingPageId" => "string",
                    ]
                ],
            ],

            "data" => [
                [
                    "key" => "Address",
                    "val" => "Address value"
                ],
                [
                    "key" => "Email address",
                    "val" => "testemail@gmail.com"
                ],
                [
                    "key" => "First name",
                    "val" => "John"
                ],
                [
                    "key" => "Last name",
                    "val" => "Smith"
                ],
                [
                    "key" => "Contry",
                    "val" => "USA"
                ],
            ]
        ];
        $result = $idomooVideo->generate($data);

        return response()->json([
            'success' => true,
        ]);
    }
}
