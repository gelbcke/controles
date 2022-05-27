<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unidade extends Model
{
   	//
	public function blocos()
    {
        return $this->hasMany('App\Models\Bloco');
    }

	public function ambientes()
    {
        return $this->hasMany('App\Models\Ambiente');
    }

    protected $fillable = ['name', 'empregadora', 'cnpj', 'endereco'];
}
