<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Tarefa;

class UserStory extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'user_story';

    protected $fillable = [
        'nome', 'descricao', 'pontuacao', 'prioridade', 'status', 'projeto_git_id'
    ];

}
