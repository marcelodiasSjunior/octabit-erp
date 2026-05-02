<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The tables that should have the company_id column added.
     *
     * @var array
     */
    private $tables = [
        'clients',
        'services',
        'products',
        'contracts',
        'client_services',
        'accounts_receivable',
        'accounts_payable',
        'client_products',
        'client_interactions',
        'quotes',
        'quote_items',
        'pipelines',
        'pipeline_stages',
        'deals',
        'deal_activities',
        'deal_slas',
        'deal_followup_rules',
        'deal_sla_violations',
        'deal_stage_history',
        'deal_followup_webhooks',
        'tags',
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach ($this->tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                if (!Schema::hasColumn($table->getTable(), 'company_id')) {
                    $table->unsignedBigInteger('company_id')->nullable()->index()->after('id');
                    $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach ($this->tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                if (Schema::hasColumn($table->getTable(), 'company_id')) {
                    $table->dropForeign(['company_id']);
                    $table->dropColumn('company_id');
                }
            });
        }
    }
};
