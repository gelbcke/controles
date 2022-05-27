<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    //
    public function software()
    {
        return $this->belongsTo(SoftwareList::class);
    }

    public function termo()
    {
        return $this->belongsTo(TermosResponsabilidade::class);
    }
}
