<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Software extends Model
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
         return $this->belongsTo('App\Models\Ambiente', 'id');
    }

    public function imagem()
    {
        return $this->belongsTo(Imagem::class);
    }

    public function software_list()
    {
        return $this->belongsTo(SoftwareList::class);
    }

    //fillable fields
    protected $fillable = ['imagem_id','img_version', 'software_list_id', 'app_version'];

    // Removida Aspas dos dados inseridos no DB
    /*
	protected $casts = [
        'application' => 'array',
        'app_version' => 'array'
    ];
    */

}
