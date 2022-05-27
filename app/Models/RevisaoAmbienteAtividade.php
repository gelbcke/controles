<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RevisaoAmbienteAtividade extends Model
{
    //
    public function servico()
    {
      return $this->belongsTo(RevisaoAmbiente::class);
    }

    protected $fillable = ['nivel','atividades'];
}
