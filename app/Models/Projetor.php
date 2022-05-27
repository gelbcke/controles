<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Projetor extends Model
{
    //
    public function projetor()
    {
         return $this->belongsTo('App\Models\ProjetorModelo', 'projetor_id');
    }

    public function unidade()
    {
         return $this->belongsTo('App\Models\Unidade');
    }

     public function bloco()
    {
         return $this->belongsTo('App\Models\Bloco');
    }

     public function ambiente()
    {
         return $this->belongsTo('App\Models\Ambiente');
    }

    protected $fillable = ['unidade_id', 'bloco_id', 'ambiente_id', 'projetor_id', 'patrimonio', 'ns', 'infra' ,'modelo_suporte'];
}
