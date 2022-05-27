<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlocoTecnico extends Model
{
    //
    public function bloco()
    {
      return $this->belongsTo('App\Models\Bloco');
    }

    protected $fillable = ['user_id', 'bloco_id'];


}
