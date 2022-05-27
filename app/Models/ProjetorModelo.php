<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjetorModelo extends Model
{
    //
	public function projetor()
    {
         return $this->hasMany('App\Models\Projetor');
    }

    protected $fillable = [
    	'fabricante',
    	'modelo',
    	'nome',
    	'pixels',
    	'lumens',
    	'max_resolution',
    	'lamp_max_time',
    	'distance_projection',
    	'max_screen_size',
    	'contrast',
    	'color_reproduction',
    	'sound',
    	'projection_mode',
    	'energy_consumption',
    	'weight',
    	'wireless',
    	'projector_image'
	];
}
