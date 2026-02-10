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
        Schema::create('course_requirements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->unique()->constrained('courses')->onDelete('cascade');
            $table->integer('min_jamb_score')->default(180);
            $table->integer('min_post_utme_score')->default(50);
            $table->integer('min_olevel_credits')->default(5);
            $table->integer('max_olevel_sittings')->default(2);
            $table->text('additional_requirements')->nullable();
            $table->timestamps();

            $table->index('course_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_requirements');
    }
};



