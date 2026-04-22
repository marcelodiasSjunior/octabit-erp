<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deal_stage_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('deal_id')->constrained()->cascadeOnDelete();
            $table->foreignId('from_stage_id')->nullable()->constrained('pipeline_stages')->nullOnDelete();
            $table->foreignId('to_stage_id')->constrained('pipeline_stages')->restrictOnDelete();
            $table->dateTime('entered_at');
            $table->dateTime('exited_at')->nullable();
            $table->unsignedInteger('days_in_stage')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('trigger_type')->nullable();
            $table->string('reason')->nullable();
            $table->text('notes')->nullable();
            $table->decimal('deal_value_at_stage', 12, 2)->nullable();
            $table->decimal('probability_at_stage', 5, 2)->nullable();
            $table->boolean('was_won_or_lost')->default(false);
            $table->timestamps();

            $table->index(['deal_id', 'entered_at']);
            $table->index(['to_stage_id', 'exited_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deal_stage_history');
    }
};