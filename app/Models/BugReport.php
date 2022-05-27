<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BugReport extends Model
{
    //
    public function user()
    {
      return $this->belongsTo(User::class);
    }

    protected $fillable = ['user_id', 'modulo', 'versao', 'status', 'descricao'];
}
