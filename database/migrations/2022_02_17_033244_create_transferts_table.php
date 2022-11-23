<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransfertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transferts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id_from')->unsigned()->index();
            $table->bigInteger('user_id_to')->unsigned()->index();
            $table->double('montant');
            $table->double('frais');
            $table->double('taux_from');
            $table->double('taux_to');
            $table->string('pays_from');
            $table->string('pays_to');
            $table->string('ip_from');
            $table->string('ip_to');

            //TODO Ajouter les colonnes pour lorsque le client n'est pas client Baxe
            $table->timestamps();

            $table->foreign('user_id_from')->references('id')->on('users');
            $table->foreign('user_id_to')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transferts');
    }
}
