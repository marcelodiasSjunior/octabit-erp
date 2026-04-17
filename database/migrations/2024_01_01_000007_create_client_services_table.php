<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('client_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->foreignId('service_id')->constrained()->cascadeOnDelete();
            $table->decimal('custom_price', 10, 2)->nullable()->comment('Overrides service base_price when set');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->enum('status', ['active', 'suspended', 'canceled'])->default('active');
            $table->timestamps();

            $table->index('status');
            $table->unique(['client_id', 'service_id', 'start_date'], 'unique_client_service_start');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_services');
    }
};
