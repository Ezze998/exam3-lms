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
    Schema::create('enrollments', function (Blueprint $table) {
        $table->id();

        $table->foreignId('user_id')
              ->constrained()
              ->onDelete('cascade');

        $table->foreignId('course_id')
              ->constrained()
              ->onDelete('cascade');

        $table->timestamp('created_at')->useCurrent(); // Acts as 'enrolled_at'

        // COMPOSITE KEY: Prevents a student from enrolling in the same course twice
        $table->unique(['user_id', 'course_id']);
    });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
