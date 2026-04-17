<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('zip_code', 9)->nullable()->after('notes');
            $table->string('address')->nullable()->after('zip_code');
            $table->string('city')->nullable()->after('address');
            $table->string('state', 2)->nullable()->after('city');
        });
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn(['zip_code', 'address', 'city', 'state']);
        });
    }
};
