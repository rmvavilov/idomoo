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
            $storyBoard = StoryBoardRepository::get();

            return response()->json([
                'success' => true,
                'name' => $storyBoard->name,
                'data' => $storyBoard->data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
            ]);
        }
    }

    public function store(VideoStoreRequest $request)
    {
        try {
            $idomooVideo = new IdomooVideo();
            $video = $idomooVideo->generate($request->toArray());
            $videoData = VideosRepository::getVideoForFrontend($video);

            return response()->json([
                'success' => true,
                'video' => $videoData
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
            ]);
        }
    }

    public function show(Video $video)
    {
        try {
            $videoData = VideosRepository::getVideoForFrontend($video);

            return response()->json([
                'success' => true,
                'video' => $videoData,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
            ]);
        }

    }
}
