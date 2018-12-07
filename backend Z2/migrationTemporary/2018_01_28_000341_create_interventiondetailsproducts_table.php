<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInterventiondetailsproductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interventiondetailsproducts', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('intervention_detail_id')->unsigned();
            $table->integer('installer_product_id')->unsigned();
            $table->integer('created_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('intervention_detail_id')->references('id')->on('interventiondetails')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('installer_product_id')->references('id')->on('installerproducts')->onDelete('cascade')->onUpdate('cascade');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('interventiondetailsproducts');
    }
}
