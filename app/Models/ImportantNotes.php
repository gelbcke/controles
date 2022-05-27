<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImportantNotes extends Model
{
    //
	public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $dates = ['period'];

    protected $fillable = [
		'user_id',
		'reference',
		'period_start',
        'period_end',
		'about',
		'description',
    ];
}
