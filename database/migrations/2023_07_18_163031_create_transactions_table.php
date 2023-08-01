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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users', 'id')->nullOnDelete();
            $table->foreignId('origin_cost_center_id')->nullable()->constrained('cost_centers', 'id')->nullOnDelete();
            $table->foreignId('destiny_cost_center_id')->nullable()->constrained('cost_centers', 'id')->nullOnDelete();
            $table->foreignId('employee_id')->nullable()->constrained('employees', 'id')->nullOnDelete();
            $table->foreignId('expense_concept_id')->nullable()->constrained('expense_concepts', 'id')->nullOnDelete();
            $table->string('transaction_type')->nullable();
            $table->double('amount', 8, 2)->nullable();
            $table->date('date_time')->nullable();
            $table->string('notes')->nullable();
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
        Schema::dropIfExists('transactions');
    }
};
