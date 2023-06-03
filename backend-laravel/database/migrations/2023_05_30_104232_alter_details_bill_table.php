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
        Schema::table('details_bill', function (Blueprint $table) {
            $table->foreignId('id_bills')->constrained("bills");
            $table->foreignId('id_products')->constrained("products");

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('details_bill', function (Blueprint $table) {
            $table->dropForeign('details_bill_id_bills_foreign');
            $table->dropForeign('details_bill_id_products_foreign');

            $table->dropColumn(['id_bills', 'id_products']);
        });
    }
};
