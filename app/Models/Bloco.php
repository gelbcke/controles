<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bloco extends Model
{
    //
    public function ambientes()
    {
        return $this->hasMany('App\Models\Ambiente');
    }

    public function unidade()
    {
        return $this->belongsTo(Unidade::class);
    }

    protected $fillable = ['name','unidade_id'];
}
