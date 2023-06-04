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
        Schema::table('category', function (Blueprint $table) {
            $table->foreignId('id_users')->constrained("users");
            $table->foreignId('id_product')->constrained("products");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('category', function (Blueprint $table) {
            $table->dropForeign('category_id_users_foreign');
            $table->dropForeign('category_id_product_foreign');

            $table->dropColumn(['id_users', 'id_product']);
        });
    }
};
