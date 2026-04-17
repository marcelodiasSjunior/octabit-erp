<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('client_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('quantity')->default(1);
            $table->decimal('unit_price', 10, 2)->nullable()->comment('Overrides product price when set');
            $table->date('purchased_at');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['client_id', 'purchased_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_products');
    }
};
