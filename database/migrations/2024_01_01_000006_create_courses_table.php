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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('faculty_id')->constrained('faculties')->onDelete('cascade');
            $table->string('name', 255);
            $table->string('code', 20)->unique();
            $table->text('description')->nullable();
            $table->integer('jamb_cutoff')->default(180);
            $table->integer('post_utme_cutoff')->default(50);
            $table->integer('duration_years')->default(4);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('faculty_id');
            $table->index('code');
            $table->index('is_active');
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






