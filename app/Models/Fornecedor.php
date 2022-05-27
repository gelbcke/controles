<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    //
    protected $fillable = ['status', 'nome_fantasia', 'razao_social', 'cnpj', 'tel_1', 'tel_2', 'tel_3', 'email', 'endereco', 'cidade', 'estado', 'pais', 'cep', 'site', 'obs'];
}
