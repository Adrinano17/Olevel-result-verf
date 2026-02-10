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
        Schema::create('admission_validations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('jamb_result_id')->constrained('jamb_results')->onDelete('cascade');
            $table->foreignId('post_utme_result_id')->nullable()->constrained('post_utme_results')->onDelete('set null');
            $table->foreignId('olevel_verification_id')->constrained('verification_requests')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->enum('validation_status', ['pending', 'eligible', 'not_eligible', 'provisionally_admitted'])->default('pending');
            $table->boolean('jamb_valid')->default(false);
            $table->json('jamb_validation_details')->nullable();
            $table->boolean('olevel_valid')->default(false);
            $table->json('olevel_validation_details')->nullable();
            $table->boolean('post_utme_valid')->nullable();
            $table->json('post_utme_validation_details')->nullable();
            $table->boolean('overall_eligible')->default(false);
            $table->json('rejection_reasons')->nullable()->comment('Array of reasons if not eligible');
            $table->timestamp('validated_at')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('jamb_result_id');
            $table->index('course_id');
            $table->index('validation_status');
            $table->index('overall_eligible');
            $table->index('validated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admission_validations');
    }
};



