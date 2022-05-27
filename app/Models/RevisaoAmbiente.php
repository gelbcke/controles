<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RevisaoAmbiente extends Model
{
    //
	public $table = "revisao_ambientes";
    
    protected $dates = [
        'created_at', 
        'updated_at', 
        'tmr', 
        'start', 
        'end'
    ];

    public function unidade()
    {
        return $this->belongsTo(Unidade::class);
    }

    public function bloco()
    {
        return $this->belongsTo(Bloco::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ambiente()
    {
      return $this->belongsTo(Ambiente::class);
    }

    public function atividades()
    {
      return $this->belongsTo(RevisaoAmbienteAtividade::class);
    }

    protected $fillable = [
        'unidade_id',
        'bloco_id','sala',
        'ambiente_id',
        'user_id',
        'servico_id',
        'rev_id',
        'nivel',
        'participante', 
        'rev_status'
    ];
}
