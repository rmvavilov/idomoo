<?php

namespace App\Http\Controllers;

use App\Helpers\IdomooStoryBoard;
use App\Http\Requests\VideoStoreRequest;
use http\Client\Curl\User;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'videos' => auth()->user()->videos,
        ]);
    }

    public function create()
    {
        $idomoo = new IdomooStoryBoard();
        $storyBoardArr = $idomoo->get();

        return response()->json([
            'success' => true,
            'story_board' => $storyBoardArr,
        ]);
    }

    public function store(VideoStoreRequest $request)
    {
        return response()->json([
            'success' => true,
        ]);
    }
}
