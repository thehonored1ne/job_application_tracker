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
        Schema::create('interview_rounds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_application_id')->constrained('job_applications')->cascadeOnDelete();
            $table->string('round_type', 50)->default('screening');
            $table->dateTime('scheduled_at')->nullable();
            $table->unsignedSmallInteger('duration_minutes')->nullable()->default(45);
            $table->string('meeting_url')->nullable();
            $table->string('location')->nullable();
            $table->string('interviewer_name')->nullable();
            $table->string('interviewer_title')->nullable();
            $table->string('interviewer_email')->nullable();
            $table->string('interviewer_linkedin')->nullable();
            $table->longText('prep_notes')->nullable();
            $table->longText('questions_asked')->nullable();
            $table->longText('takeaways')->nullable();
            $table->unsignedTinyInteger('rating')->nullable();
            $table->string('status', 50)->default('scheduled');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interview_rounds');
    }
};
