<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoftwareKey extends Model
{
    //
	protected $dates = ['due_date', 'date_last_order'];

	public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    //fillable fields
    protected $fillable = ['software_id', 'version', 'key', 'server', 'server_port', 'account', 'account_password', 'obs', 'date_last_order', 'supplier_id', 'due_date', 'qt_license', 'nfe', 'oc', 'renovation_period', 'install_soft_local', 'install_lic_local', 'description', 'nfe_file', 'contract_file'];


    public function software()
    {
        return $this->belongsTo(SoftwareList::class);
    }

     public function supplier()
    {
        return $this->belongsTo('App\Models\Fornecedor');
    }
}
