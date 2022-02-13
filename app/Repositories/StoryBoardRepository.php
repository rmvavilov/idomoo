<?php

namespace App\Repositories;

use App\Helpers\IdomooStoryBoard;
use App\Models\StoryBoard;
use Carbon\Carbon;

class StoryBoardRepository
{
    public static function get(): StoryBoard
    {
        $storyBoard = StoryBoard::query()
            ->where('storyboard_id', IdomooStoryBoard::DEFAULT_STORY_BOARD_ID)
            ->first();

        if ($storyBoard) {
            // TODO: check IdomooStoryBoard::DEFAULT_STORY_BOARD_ID and update if need
            return $storyBoard;
        }

        $idomoo = new IdomooStoryBoard();
        $storyBoardArr = $idomoo->get();
        $storyBoard = new StoryBoard($storyBoardArr);
        $storyBoard->last_modified_at = $storyBoardArr['last_modified_string'] ?? Carbon::now();
        $storyBoard->save();

        return $storyBoard;
    }
}
