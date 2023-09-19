<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('songs', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('title');
            $table->text('story');
            $table->string('main_audio_link');
            $table->string('preview_link');
            $table->text('lyrics');
            $table->integer('number_of_listens')->nullable();
            $table->string('producer_name');
            $table->integer('duration');
            $table->integer('number_of_verses');
            $table->boolean('original_instrumental');
            $table->boolean('has_sample');
            $table->boolean('is_explicit');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('songs');
    }
};
