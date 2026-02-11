<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
    Schema::create('lessons', function (Blueprint $table) {
        $table->id();

        // If the course is permanently deleted, delete the lessons too
        $table->foreignId('course_id')
              ->constrained()
              ->onDelete('cascade');

        $table->string('title');
        $table->text('content'); // Could be text, markdown, or a video URL
        $table->integer('position')->default(0); // To order lessons

        $table->timestamps();
    });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
