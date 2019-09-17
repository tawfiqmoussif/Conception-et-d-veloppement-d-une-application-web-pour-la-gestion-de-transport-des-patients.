<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDemandesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demandes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->datetime('deleted_at')->nullable();
            $table->boolean('accompagnant');
            $table->boolean('dossier_medical');
            $table->boolean('billet_rose');
            $table->integer('user_id_demandeur')->unsigned();
            $table->foreign('user_id_demandeur')->references('id')->on('users');
            $table->integer('user_id_brancardier')->unsigned()->nullable();
            $table->foreign('user_id_brancardier')->references('id')->on('users');
            $table->integer('id_service_source')->unsigned();
            $table->foreign('id_service_source')->references('id')->on('services');
            $table->integer('id_service_destination')->unsigned();
            $table->foreign('id_service_destination')->references('id')->on('services');
            $table->integer('hospitalisation_id')->unsigned();
            $table->foreign('hospitalisation_id')->references('id')->on('hospitalisations');
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
        Schema::dropIfExists('demandes');
    }
}
