<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    //
	protected $dates = ['start_date', 'end_date'];

	public function supplier()
    {
        return $this->belongsTo('App\Models\Fornecedor');
    }

	public function unidade()
    {
        return $this->belongsTo(Unidade::class);
    }

 	protected $fillable = ['unidade_id','supplier_id','product','description','start_date','end_date', 'month_cost', 'total_cost', 'obs', 'status'];
}
