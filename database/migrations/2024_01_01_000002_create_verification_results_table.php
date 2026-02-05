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
        Schema::create('verification_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('verification_request_id')->unique()->constrained('verification_requests')->onDelete('cascade');
            $table->string('candidate_name')->nullable();
            $table->string('response_code', 20);
            $table->text('response_message')->nullable();
            $table->json('subjects')->nullable();
            $table->json('raw_response')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('verification_request_id');
            $table->index('response_code');
            $table->index('verified_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verification_results');
    }
};




