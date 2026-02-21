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
        Schema::create('course_olevel_subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->string('subject_name', 100);
            $table->string('min_grade', 10)->default('C6')->comment('Minimum acceptable grade');
            $table->boolean('is_required')->default(true);
            $table->timestamps();

            $table->index('course_id');
            $table->index(['course_id', 'is_required']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_olevel_subjects');
    }
};






