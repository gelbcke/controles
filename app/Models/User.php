<?php

namespace App\Models;

use App\Traits\LockableTrait;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, LockableTrait, HasRoles;

    protected $dates = [
        'updated_at',
        'created_at',
        'last_login_at',
        'two_factor_expires_at'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'matricula',
        'telefone',
        'unidade_id',
        'periodo',
        'horario_de_entrada',
        'saida_intervalo',
        'retorno_intervalo',
        'horario_de_saida',
        'cidade',
        'bairro',
        'endereco',
        'tipo_transporte',
        'lider_id',
        'cargo',
        'admissao',
        'rg',
        'cpf',
        'last_login_at',
        'last_login_ip',
        'two_factor_code',
        'two_factor_expires_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function bloco()
    {
      return $this->belongsTo('App\Models\BlocoTecnico');
    }

    public function unidade()
    {
      return $this->belongsTo('App\Models\Unidade');
    }

    public function lider()
    {
      return $this->belongsTo('App\Models\User');
    }

    public function generateTwoFactorCode()
    {
        $this->timestamps = false;
        $this->two_factor_code = rand(100000, 999999);
        $this->two_factor_expires_at = now()->addMinutes(10);
        $this->save();
    }

    public function resetTwoFactorCode()
    {
        $this->timestamps = false;
        $this->two_factor_code = null;
        $this->two_factor_expires_at = null;
        $this->save();
    }
}
