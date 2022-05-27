<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Imagem extends Model
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
         return $this->belongsTo('App\Models\Ambiente');
    }

    public function software_list()
    {
        return $this->belongsTo(SoftwareList::class);
    }


    protected $fillable = ['unidade_id','bloco_id','image_name','file_name','date_of_creation','version','creator','reviewer'];
    /*
    protected $hidden = [
        'unidade_id', 'bloco_id', 'image_name', 'version'
    ];
    */
}
