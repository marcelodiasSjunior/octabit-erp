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
        Schema::create('deals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('restrict');
            $table->foreignId('pipeline_id')->constrained()->onDelete('restrict');
            $table->foreignId('stage_id')->constrained('pipeline_stages')->onDelete('restrict');
            
            $table->string('title');
            $table->decimal('value', 12, 2)->default(0);
            $table->enum('status', ['open', 'won', 'lost'])->default('open');
            $table->date('expected_close_date')->nullable();
            $table->dateTime('closed_at')->nullable();
            $table->text('notes')->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            $table->index(['client_id', 'pipeline_id']);
            $table->index('stage_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deals');
    }
};
