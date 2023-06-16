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
        Schema::create('stock_in', function (Blueprint $table) {
            $table->id();
            $table->integer('tran_id')->nullable();
            $table->integer('brand_id')->nullable();
            $table->integer('generic_id')->nullable();
            $table->integer('qty')->nullable();
            $table->double('price')->nullable();
            $table->integer('discount_per')->nullable();
            $table->double('discount_amt')->nullable();
            $table->double('total_price')->nullable();
            // $table->date('tran_date')->nullable();
            // $table->integer('tran_type')->nullable();
            $table->tinyInteger('created_by')->nullable();
            $table->tinyInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_in');
    }
};
