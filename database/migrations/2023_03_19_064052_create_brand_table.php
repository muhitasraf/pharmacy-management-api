<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrandTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand', function (Blueprint $table) {
            $table->id();
            $table->string('brand_name',150)->collation('utf8_general_ci');
            $table->integer('generic_id')->nullable();
            $table->integer('company_id')->nullable();
            $table->string('type',200)->collation('utf8_general_ci')->nullable();
            $table->string('strength',200)->collation('utf8_general_ci')->nullable();
            $table->double('price')->nullable();
            $table->string('packsize',100)->collation('utf8_general_ci')->nullable();
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('brand');
    }
}
