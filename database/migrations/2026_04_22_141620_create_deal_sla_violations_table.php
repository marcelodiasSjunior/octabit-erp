<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deal_sla_violations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('deal_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sla_rule_id')->constrained('deal_slas')->cascadeOnDelete();
            $table->string('violation_type');
            $table->dateTime('due_at');
            $table->dateTime('completed_at')->nullable();
            $table->unsignedInteger('days_late')->default(0);
            $table->string('severity')->default('warning');
            $table->boolean('acknowledged')->default(false);
            $table->boolean('resolved')->default(false);
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('escalated_to')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('escalated_at')->nullable();
            $table->text('notes')->nullable();
            $table->text('resolution_notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['deal_id', 'resolved']);
            $table->index(['severity', 'acknowledged']);
            $table->index('due_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deal_sla_violations');
    }
};