<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('expense_concepts', function (Blueprint $table) {
            $table->dropConstrainedForeignId('cost_center_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('expense_concepts', function (Blueprint $table) {
            $table->foreignId('cost_center_id')->nullable()->after('name')->constrained('cost_centers','id')->nullOnDelete();
        });
    }
};
