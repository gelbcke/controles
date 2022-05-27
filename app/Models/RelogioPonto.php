<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RelogioPonto extends Model
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

    protected $fillable = [
    	'unidade_id',
    	'bloco_id',
    	'ambiente_id',
    	'pat',
    	'ns',
    	'fabricante',
    	'modelo',
      'obs'
    ];
}
