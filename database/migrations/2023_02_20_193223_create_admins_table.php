<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pays_id')->unsigned()->index();
            $table->string('nom');
            $table->string('prenoms');
            $table->string('code_postal');
            $table->string('ville');
            $table->string('email');
            $table->string('telephone');
            $table->string('fonction');

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('pays_id')->references('id')->on('pays');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
}
