<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTarefaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarefa', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('us_id');
            $table->unsignedBigInteger('responsavel_id')->index();
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->string('status');
            $table->string('prioridade')->nullable();
            $table->timestamps();
            $table->foreign('us_id')->references('id')->on('user_story')->onDelete('CASCADE');
            $table->foreign('responsavel_id')->references('provider_id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tarefa');
    }
}
