<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deal_slas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pipeline_id')->constrained()->cascadeOnDelete();
            $table->foreignId('stage_id')->nullable()->constrained('pipeline_stages')->nullOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedInteger('response_sla_hours')->default(24);
            $table->unsignedInteger('followup_interval_days')->default(3);
            $table->unsignedInteger('escalation_threshold_days')->nullable();
            $table->boolean('active')->default(true);
            $table->unsignedInteger('priority')->default(0);
            $table->unsignedInteger('max_followups')->nullable();
            $table->unsignedInteger('warning_hours_before')->default(4);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['pipeline_id', 'stage_id', 'active']);
            $table->index(['pipeline_id', 'priority']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deal_slas');
    }
};