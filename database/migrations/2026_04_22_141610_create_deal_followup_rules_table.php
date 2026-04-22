<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deal_followup_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pipeline_id')->constrained()->cascadeOnDelete();
            $table->foreignId('stage_id')->nullable()->constrained('pipeline_stages')->nullOnDelete();
            $table->foreignId('deal_sla_id')->nullable()->constrained('deal_slas')->nullOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('trigger_type');
            $table->string('trigger_value');
            $table->string('action_type');
            $table->string('activity_type')->nullable();
            $table->string('template_name')->nullable();
            $table->text('template_body')->nullable();
            $table->string('notification_channel')->nullable();
            $table->boolean('active')->default(true);
            $table->unsignedInteger('order')->default(0);
            $table->boolean('only_if_no_recent_activity')->default(true);
            $table->unsignedInteger('cooldown_hours')->default(0);
            $table->unsignedInteger('max_executions')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['pipeline_id', 'stage_id', 'active']);
            $table->index(['trigger_type', 'action_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deal_followup_rules');
    }
};