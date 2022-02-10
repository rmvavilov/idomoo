<?php

namespace App\Http\Controllers;

use App\Helpers\IdomooStoryBoard;
use App\Helpers\IdomooVideo;
use App\Models\StoryBoard;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
        $idomoo = new IdomooStoryBoard();
        $storyBoardArr = $idomoo->get();
        $storyBoardId = $storyBoardArr['storyboard_id'] ?? 0;
        $storyBoard = StoryBoard::query()
            ->where('storyboard_id', $storyBoardId)
            ->first();
        if ($storyBoard) {
            dump('Story board exist, update:');
            dump($storyBoard);
        } else {
            dump($storyBoardArr);
            $storyBoard = new StoryBoard($storyBoardArr);
            $storyBoard->data = json_encode($storyBoard->data);
            $storyBoard->last_modified_at = $storyBoardArr['last_modified_string'] ?? Carbon::now();
            $storyBoard->save();
        }
        return;

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
        return;
        return view('home');
    }
}
