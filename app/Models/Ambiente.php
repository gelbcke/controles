<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Ambiente extends Model
{
    //
    protected $dates = ['aquisicao'];
    //use HasRoles;
    //protected $guard_name = 'web';

    public function unidade()
    {
        return $this->belongsTo(Unidade::class);
    }

    public function bloco()
    {
        return $this->belongsTo(Bloco::class);
    }
    
    public function imagem()
    {
        return $this->belongsTo(Imagem::class);
    }
    
    public function software_list()
    {
        return $this->belongsTo(SoftwareList::class);
    }

    protected $fillable = ['unidade_id','bloco_id','name','sala','tipo', 'qt_maquinas', 'aquisicao', 'processador', 'ram', 'hd', 'gpu', 'gpu_memo', 'hv_proj', 'hv_printer', 'periodo_revisao_1', 'periodo_revisao_2','periodo_revisao_3', 'imagem_id', 'prox_revisao_1', 'prox_revisao_2', 'prox_revisao_3', 'participante', 'status', 'gabinete'];
}
