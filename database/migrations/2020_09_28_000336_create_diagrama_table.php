<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiagramaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diagrama', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome');
            $table->longText('descricao');
            $table->string('imagem')->nullable();
            $table->unsignedBigInteger('responsavel_id')->index()->nullable();
            $table->unsignedBigInteger('us_id')->index()->nullable();
            $table->unsignedBigInteger('projeto_git_id');
            $table->foreign('responsavel_id')->references('provider_id')->on('users');
            $table->foreign('us_id')->references('id')->on('user_story');
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
        Schema::dropIfExists('diagrama');
    }
}
