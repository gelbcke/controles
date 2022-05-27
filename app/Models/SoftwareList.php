<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoftwareList extends Model
{
	//
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

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


    protected $fillable = ['name', 'version'];
}
