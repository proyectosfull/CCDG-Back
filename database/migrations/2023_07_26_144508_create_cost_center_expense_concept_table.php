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
        Schema::create('cost_center_expense_concept', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cost_center_id')->nullable()->constrained('cost_centers','id')->nullOnDelete();
            $table->foreignId('expense_concept_id')->nullable()->constrained('expense_concepts','id')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cost_center_expense_concept_table');
    }
};
