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
        Schema::create('employee_records', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 150)->nullable();
            $table->double('monthly_salary', 8,2)->nullable();
            $table->foreignId('area_id')->nullable()->constrained('areas','id')->nullOnDelete();
            $table->foreignId('subcost_center_id')->nullable()->constrained('subcost_centers','id')->nullOnDelete();
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
        Schema::dropIfExists('employee_records');
    }
};
