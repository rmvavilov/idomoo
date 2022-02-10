<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoryBoardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('story_boards', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('storyboard_id')->unique();
            $table->string('name');
            $table->float('thumbnail_time', 8, 2);
            $table->integer('width');
            $table->integer('height');
            $table->string('thumbnail');
            $table->json('data');
            $table->dateTime('last_modified_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('story_boards');
    }
}
