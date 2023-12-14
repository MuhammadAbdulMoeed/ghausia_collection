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
        Schema::table('products', function (Blueprint $table) {
            $table->string('demo_video')->nullable()->after('photo');
            $table->string('color')->nullable()->after('demo_video' );
            $table->string('product_guide')->nullable()->after('color');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('demo_video');
            $table->dropColumn('color');
            $table->dropColumn('product_guide');
        });
    }
};
