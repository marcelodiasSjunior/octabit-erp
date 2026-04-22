<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deal_followup_webhooks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('event');
            $table->string('url');
            $table->string('secret')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->index(['event', 'active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deal_followup_webhooks');
    }
};
