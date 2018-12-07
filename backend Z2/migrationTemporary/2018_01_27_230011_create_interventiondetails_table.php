<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInterventiondetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interventiondetails', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('type')->nullable();
            $table->string('observation')->nullable();
            $table->string('status')->nullable();
            $table->integer('vehicle_id')->unsigned();
            $table->integer('intervention_id')->unsigned();
            $table->integer('created_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('intervention_id')->references('id')->on('interventions')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade')->onUpdate('cascade');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('interventiondetails');
    }
}
