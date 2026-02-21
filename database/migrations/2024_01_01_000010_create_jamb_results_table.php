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
        Schema::create('jamb_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('jamb_reg_number', 50)->unique();
            $table->integer('jamb_score')->comment('Score from 0-400');
            $table->year('exam_year');
            $table->json('subjects')->comment('Array of subjects with scores');
            $table->foreignId('first_choice_course_id')->nullable()->constrained('courses')->onDelete('set null');
            $table->foreignId('second_choice_course_id')->nullable()->constrained('courses')->onDelete('set null');
            $table->foreignId('third_choice_course_id')->nullable()->constrained('courses')->onDelete('set null');
            $table->timestamp('verified_at')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('jamb_reg_number');
            $table->index('exam_year');
            $table->index('first_choice_course_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jamb_results');
    }
};






