<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInstallerproductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('installerproducts', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('status')->nullable();
            $table->integer('product_id')->unsigned();
            $table->integer('installer_id')->unsigned();
            $table->integer('created_by')->unsigned();
            $table->foreign('installer_id')->references('id')->on('installers')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade')->onUpdate('cascade');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('installerproducts');
    }
}
