<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInterventionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interventions', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->date('intervened_at')->nullable();
            $table->string('observation')->nullable();
            $table->string('status')->nullable();
            $table->string('responsible_validation')->nullable();
            $table->integer('costumer_id')->unsigned();
            $table->integer('intervener_id')->unsigned();
            $table->integer('created_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('intervener_id')->references('id')->on('installers')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('costumer_id')->references('id')->on('costumers')->onDelete('cascade')->onUpdate('cascade');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('interventions');
    }
}
