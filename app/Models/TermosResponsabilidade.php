<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TermosResponsabilidade extends Model
{
    //
    protected $dates = ['dt_retirada', 'dt_entrega', 'dt_devolucao'];

    public function responsavel()
    {
        return $this->belongsTo(User::class);
    }

    public function gerente()
    {
        return $this->belongsTo(User::class);
    }

    public function testemunha()
    {
        return $this->belongsTo(User::class);
    }

    public function unidade()
    {
        return $this->belongsTo(Unidade::class);
    }

        protected $fillable = [
    	 	'contrato',
            'referencia',
            'fpw',
            'matricula',
            'colaborador',
            'email',
            'cpf',
            'cnpj',
            'rg',
            'vinculo',
            'cargo',
            'contato',
            'unidade_id',
            'pat',
            'ns',
            'equipamento',
            'marca',
            'modelo',
            'processador',
            'memoria',
            'hd',
            'itens_add',
            'operadora',
            'num_chip',
            'responsavel_id',
            'gerente_id',
            'testemunha_id',
            'gestor_colab',
            'dt_retirada',
            'dt_entrega',
            'dt_devolucao',
            'status',
            'arquivado',
            'empresa',
            'obs'
    ];
}
