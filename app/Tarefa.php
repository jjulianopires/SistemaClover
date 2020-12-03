<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\ForeignKeyDefinition;
use App\User;
use App\UserStory;

class Tarefa extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'tarefa';

    protected $fillable = [
        'nome', 'descricao', 'status', 'prioridade', 'responsavel_id', 'us_id'
    ];

    
}
