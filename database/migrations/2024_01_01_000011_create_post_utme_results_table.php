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
        Schema::create('post_utme_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('jamb_result_id')->constrained('jamb_results')->onDelete('cascade');
            $table->string('post_utme_reg_number', 50);
            $table->integer('post_utme_score')->comment('Score from 0-100');
            $table->year('exam_year');
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->timestamp('verified_at')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('jamb_result_id');
            $table->index('post_utme_reg_number');
            $table->index('course_id');
            $table->index('exam_year');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_utme_results');
    }
};



