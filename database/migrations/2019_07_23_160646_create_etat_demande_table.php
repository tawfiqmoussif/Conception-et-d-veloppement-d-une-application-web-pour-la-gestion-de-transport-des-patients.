<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEtatDemandeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etat_demande', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->datetime('deleted_at')->nullable();
            $table->integer('demande_id')->unsigned();
            $table->foreign('demande_id')->references('id')->on('demandes');
            $table->integer('etat_id')->unsigned();
            $table->foreign('etat_id')->references('id')->on('etats');
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
        Schema::dropIfExists('etat_demande');
    }
}
