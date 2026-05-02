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
        Schema::table('quotes', function (Blueprint $table) {
            $table->unsignedBigInteger('sequential_number')->nullable()->index()->after('company_id');
        });

        Schema::table('contracts', function (Blueprint $table) {
            $table->unsignedBigInteger('sequential_number')->nullable()->index()->after('company_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quotes', function (Blueprint $table) {
            $table->dropColumn('sequential_number');
        });

        Schema::table('contracts', function (Blueprint $table) {
            $table->dropColumn('sequential_number');
        });
    }
};
