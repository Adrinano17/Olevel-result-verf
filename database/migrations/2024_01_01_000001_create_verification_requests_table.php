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
        Schema::create('verification_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('exam_number', 50);
            $table->year('exam_year');
            $table->enum('exam_body', ['WAEC', 'NECO']);
            $table->string('result_type', 50);
            $table->enum('status', ['pending', 'success', 'failed', 'timeout'])->default('pending');
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();

            // Indexes for better query performance
            $table->index('user_id');
            $table->index('exam_number');
            $table->index('exam_year');
            $table->index('exam_body');
            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verification_requests');
    }
};




