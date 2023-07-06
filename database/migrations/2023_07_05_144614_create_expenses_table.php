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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('cost_center_id')->nullable()->constrained('catalogs','id')->nullOnDelete();
            $table->foreignId('subcost_center_id')->nullable()->constrained('subcatalogs','id')->nullOnDelete();
            $table->foreignId('subcatalog_id')->nullable()->constrained('subcatalogs','id')->nullOnDelete();
            $table->double('amount',8,2)->nullable();
            $table->string('observations')->nullable();
            $table->date('date')->nullable();
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
        Schema::dropIfExists('expenses');
    }
};
