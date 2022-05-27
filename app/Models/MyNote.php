<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MyNote extends Model
{
	//
	protected $fillable = ['user_id','note','status'];
}
