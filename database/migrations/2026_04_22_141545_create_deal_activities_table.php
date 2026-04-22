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
        Schema::create('deal_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('deal_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            
            $table->enum('type', ['call', 'email', 'meeting', 'task', 'whatsapp'])->default('call');
            $table->string('title');
            $table->text('notes')->nullable();
            $table->dateTime('scheduled_at')->nullable();
            $table->boolean('done')->default(false);
            $table->dateTime('completed_at')->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            $table->index(['deal_id', 'done']);
            $table->index('scheduled_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deal_activities');
    }
};
