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
        Schema::table('categories', function (Blueprint $table) {
            $table->smallInteger('top_bar')->default(0)->after('status');
            $table->smallInteger('slider')->default(0)->after('top_bar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
           $table->dropColumn('top_bar');
           $table->dropColumn('slider');
        });
    }
};
