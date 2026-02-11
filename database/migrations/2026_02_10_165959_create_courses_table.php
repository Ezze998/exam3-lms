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
    Schema::create('courses', function (Blueprint $table) {
        $table->id();

        // Links to the user who created it (must be a teacher)
        $table->foreignId('instructor_id')
              ->constrained('users')
              ->onDelete('cascade');

        $table->string('title');
        $table->string('slug')->unique(); // Good for SEO-friendly URLs
        $table->text('description')->nullable();
        $table->string('thumbnail')->nullable(); // Path to image file

        $table->timestamps();
        $table->softDeletes(); // Adds 'deleted_at' column
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
