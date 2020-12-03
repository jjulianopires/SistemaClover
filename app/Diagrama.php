<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diagrama extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'diagrama';

    protected $fillable = [
        'nome', 'descricao', 'imagem', 'responsavel_id', 'us_id', 'projeto_git_id'
    ];
}
