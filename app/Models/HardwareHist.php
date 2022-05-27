<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HardwareHist extends Model
{
    //
    public function unidade()
    {
        return $this->belongsTo(Unidade::class);
    }

    public function bloco()
    {
        return $this->belongsTo(Bloco::class);
    }

	public function ambiente()
    {
         return $this->belongsTo(Ambiente::class);
    }

	public function user()
    {
         return $this->belongsTo(User::class);
    }

    protected $dates 	= ['aquisicao'];

    protected $fillable = ['ambiente_id', 'user_id', 'qt_maquinas', 'aquisicao', 'processador', 'ram', 'hd', 'gpu', 'gpu_memo', 'gabinete'];
}
