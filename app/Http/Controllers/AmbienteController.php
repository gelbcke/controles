<?php

namespace App\Http\Controllers;

use App\Models\Ambiente;
use App\Models\Unidade;
use App\Models\Bloco;
use App\Models\Software;
use App\Models\Imagem;
use App\Models\BlocoTecnico;
use App\Models\RevisaoAmbienteAtividade;
use App\Models\Projetor;
use App\Models\Impressora;
use App\Models\HardwareHist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as Input;
use Spatie\Permission\Traits\HasRoles;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\Element\TextRun;
use PhpOffice\PhpWord\SimpleType\TblWidth;
use Illuminate\Validation\ValidationException;
use Auth, Session, Datatables, Toastr;
use DB, Route;
use Carbon\Carbon;

class AmbienteController extends Controller
{
    use         HasRoles;
    private     $ambiente;
    protected   $request;

    public function __construct(Request $request, Ambiente $ambiente)
    {
        $this->middleware('auth');
        $this->ambiente     = $ambiente;
        $this->request      = $request;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if(auth()->user()->can('Visualizar Ambientes'))
        {
            $unidades = Unidade::all()->pluck('name', 'id');
            
            $atv_n1 = RevisaoAmbienteAtividade::where('nivel', 'Nível 1')->value('atividades');  
            $atv_n2 = RevisaoAmbienteAtividade::where('nivel', 'Nível 2')->value('atividades'); 
            $atv_n3 = RevisaoAmbienteAtividade::where('nivel', 'Nível 3')->value('atividades'); 

            $ambientes = Ambiente::whereNull('status')
            ->orderby('unidade_id', 'asc')
            ->orderby('bloco_id', 'asc')
            ->orderby('id', 'asc')                
            ->get();
            return view('ambiente.index',compact('ambientes', 'unidades', 'atv_n1', 'atv_n2', 'atv_n3'));
        }
        else
        {
            return view('errors.401');
        }   
    }

    public function ambList(Ambiente $ambiente, Request $request)
    {
        //
        if(auth()->user()->can('Visualizar Ambientes'))
        {
        $today = Carbon::today()->startOfDay();

        $ambientes = DB::table('ambientes')
            ->join('unidades', 'ambientes.unidade_id', '=', 'unidades.id')
            ->join('blocos', 'ambientes.bloco_id', '=', 'blocos.id')
            ->select(['ambientes.unidade_id', 
                'unidades.name as unidade_name', 
                'ambientes.bloco_id', 
                'blocos.name as bloco_name', 
                DB::raw('CONCAT(ambientes.sala, " - ", ambientes.name) as name'), 
                'ambientes.prox_revisao_1 as prox_revisao_1', 
                'ambientes.prox_revisao_2 as prox_revisao_2', 
                'ambientes.prox_revisao_3 as prox_revisao_3',
                'ambientes.id as id',
                'ambientes.status as status',
                'ambientes.imagem_id as imagem',
                'ambientes.qt_maquinas as qt_maquinas',
                'ambientes.aquisicao as aquisicao',
                'ambientes.processador as processador',
                'ambientes.ram as ram',
                'ambientes.hd as hd',
                'ambientes.hv_proj as hv_proj',
                'ambientes.hv_printer as hv_printer'
            ])
            ->where( function ($q) {
                    $q->whereNull("ambientes.status")
                    ->orwhere("ambientes.status", 1);
                } );

        return datatables()->of($ambientes)
            ->editColumn('prox_revisao_1', function ($ambientes) use ($today)
            {
             if($ambientes->prox_revisao_1 >= $today && $ambientes->prox_revisao_1 != null){
                    return date('d/m/Y', strtotime($ambientes->prox_revisao_1) );
                }elseif ($ambientes->prox_revisao_1 <= $today && $ambientes->prox_revisao_1 != null){
                    return '
                            <font color="#f4424b"> 
                            '. date('d/m/Y', strtotime($ambientes->prox_revisao_1) ) . '
                            </font>
                        ';
                }else{
                    return '';
                }
          })
            ->editColumn('prox_revisao_2', function ($ambientes) use ($today)
            {
              if($ambientes->prox_revisao_2 >= $today && $ambientes->prox_revisao_1 != null){
                    return date('d/m/Y', strtotime($ambientes->prox_revisao_2 ) );
                }elseif ($ambientes->prox_revisao_2 <= $today && $ambientes->prox_revisao_1 != null){
                    return '
                            <font color="#f4424b"> 
                            '. date('d/m/Y', strtotime($ambientes->prox_revisao_2) ) . '
                            </font>                         
                        ';
                }else{
                    return '';
                }
            })
            ->editColumn('prox_revisao_3', function ($ambientes) use ($today)
            {
                if($ambientes->prox_revisao_3 >= $today && $ambientes->prox_revisao_1 != null){
                    return date('d/m/Y', strtotime($ambientes->prox_revisao_3) );
                }elseif ($ambientes->prox_revisao_3 <= $today && $ambientes->prox_revisao_1 != null){
                    return '
                            <font color="#f4424b"> 
                            '. date('d/m/Y', strtotime($ambientes->prox_revisao_3) ) . '
                            </font>                        
                        ';
                }else{
                    return '';
                }
            })   
            ->addColumn('admin_opt', function($row) {
                if($row->status == 1 || $row->status == null){
                return '
                    <div class="btn-group">
                         <button type="button" class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> <span class="caret"></span></button>
                         <ul class="dropdown-menu" role="menu" style="right: 0 !important; left: auto;">
                            <li>
                                <a href="ambiente/'. $row->id .'">Detalhes</a>
                            </li>   
                            <li>
                                <a href="ambiente/hardware_hist/'.$row->id.'">Alteração de Hardware</a>
                            </li>
                            <li>
                                <a href="ambiente/'.$row->id.'/edit">Editar</a>
                            </li>
                            <li class="divider"></li> 
                            <li> 
                               <a href="ambiente/delete/'.$row->id.'">Desabilitar</a>
                            </li>  
                         </ul>
                      </div>
                    ';

                }else{
                return '
                    <div class="btn-group">
                         <button type="button" class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> <span class="caret"></span></button>
                         <ul class="dropdown-menu" role="menu" style="right: 0 !important; left: auto;">
                            <li>
                                <a href="ambiente/'. $row->id .'">Detalhes</a>
                            </li> 
                            <li>
                                <a href="ambiente/hardware_hist/'.$row->id.'">Alteração de Hardware</a>
                            </li>
                            <li>
                                <a href="ambiente/'.$row->id.'/edit">Editar</a>
                            </li>
                            <li class="divider"></li>
                            <li> 
                               <a href="ambiente/ativar/'.$row->id.'">Habilitar</a>
                            </li>
                         </ul>
                      </div>
                    ';
                }                   
            })
            ->addColumn('img', function($row) {                    
                if($row->imagem > 0)
                {
                    return '<i class="fab fa-windows" title="Ambiente Possui Imagem"></i>';
                }
                else if($row->imagem == "0")
                {
                    return '<i class="fas fa-times" title="Não há imagem para este ambiente."></i>';
                }
            })
            ->addColumn('proj', function($row) {                 
                if($row->hv_proj > 0)
                {
                    return '<i class="fas fa-video" title="Possuí Projetor" alt="Ambiente possui projetor."></i>';
                }
                else if($row->hv_proj == "0")
                {
                    return '<i class="fas fa-times" title="Não há projetor neste ambiente."></i>';
                }
            })
            ->addColumn('hard', function($row) {                   

                    if(($row->qt_maquinas > 0) && ($row->hv_printer > 0))
                    {
                        return '<i class="fas fa-list-ol" title="Possui Hardware e Impressora."></i>';
                    }
                    else if(($row->qt_maquinas > 0) && ($row->hv_printer == "0" || $row->hv_printer == null))
                    {
                        return '<i class="fas fa-desktop" title="Possui Hardware (Não possui impressora)."></i>';
                    }
                    else if(($row->qt_maquinas == "0") && ($row->hv_printer > 0))
                    {
                        return '<i class="fas fa-print" title="Possui Impressora (Não possui Hardware)."></i>';
                    }
                    else if(($row->qt_maquinas == null) && ($row->hv_printer == "0"))
                    {
                        return '<i class="fas fa-times" title="Não Possui Impressora"></i>';
                    }
                    else if(($row->qt_maquinas == "0") && ($row->hv_printer == null))
                    {
                        return '<i class="fas fa-times" title="Não Possui Hardware"></i>';
                    }
                    else if(($row->qt_maquinas == null) && ($row->hv_printer > 0))
                    {
                        return '<i class="fas fa-print" title="Possui Impressora."></i>';
                    }
                    else if (($row->qt_maquinas == "0") && ($row->hv_printer == "0")){
                        return '<i class="fas fa-times" title="Não há nenhum hardware neste ambiente."></i>';
                    }
                    
            })
            ->addColumn('user_opt', function($row) {
                    return '
                    <div class="btn-group">
                         <button type="button" class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> <span class="caret"></span></button>
                         <ul class="dropdown-menu" role="menu" style="right: 0 !important; left: auto;">
                            <li><a href="ambiente/'. $row->id .'">Detalhes</a></li>                  
                         </ul>
                      </div>
                    ';
            })


            ->rawColumns(['prox_revisao_1', 'prox_revisao_2', 'prox_revisao_3', 'admin_opt', 'img', 'proj', 'hard', 'user_opt'])
            ->make(true);
            }
        }

        // Mostra apenas ambientes que estão desabilitados
        public function amb_disabled()
        {
            //
            if(auth()->user()->can('Visualizar Ambientes'))
            {
                $today          = Carbon::today()->startOfDay();
                $tomorrow       = Carbon::tomorrow()->startOfDay();
                $aftertomorrow  = Carbon::tomorrow()->endOfDay();
                $unidades       = Unidade::all()->pluck('name', 'id');

                $atv_n1 = RevisaoAmbienteAtividade::where('nivel', 'Nível 1')->value('atividades');  
                $atv_n2 = RevisaoAmbienteAtividade::where('nivel', 'Nível 2')->value('atividades'); 
                $atv_n3 = RevisaoAmbienteAtividade::where('nivel', 'Nível 3')->value('atividades'); 

                $ambientes = Ambiente::where('status', 0)
                    ->orderby('unidade_id', 'asc')
                    ->orderby('bloco_id', 'asc')
                    ->orderby('id', 'asc')
                    ->get();

                return view('ambiente.index',compact('ambientes', 'unidades', 'atv_n1', 'atv_n2', 'atv_n3', 'today', 'tomorrow', 'aftertomorrow'));
            }
            else
            {
                return view('errors.401');
            }   
        }

        public function filter(Request $request)
        {
            //  
            if(auth()->user()->can('Visualizar Revisão'))
            {
                $today          = Carbon::today()->startOfDay();
                $tomorrow       = Carbon::tomorrow()->startOfDay();
                $aftertomorrow  = Carbon::tomorrow()->endOfDay();
                $unidades       = Unidade::pluck('name', 'id');
                $unidade        = Input::get('unidade_id');
                $bloco          = Input::get('bloco_id');                       

                $atv_n1 = RevisaoAmbienteAtividade::where('nivel', 'Nível 1')->value('atividades');  
                $atv_n2 = RevisaoAmbienteAtividade::where('nivel', 'Nível 2')->value('atividades'); 
                $atv_n3 = RevisaoAmbienteAtividade::where('nivel', 'Nível 3')->value('atividades'); 

                $query = Ambiente::whereNull('status')->where('unidade_id', $unidade)
                ->when(Input::get('bloco_id') != 'empty_val', function ($query) use ($bloco) {
                    $query->where('bloco_id', $bloco);
                });

                $ambientes = $query->get();

                return view('ambiente.index', compact('ambientes', 'unidades' , 'atv_n1', 'atv_n2', 'atv_n3', 'today', 'tomorrow', 'aftertomorrow'));
            }
            else
            {
                return view('errors.401');
            }  
        }

        public function proximos_vencimentos()
        {
            $unidades   = Unidade::all()->pluck('name', 'id');
            $today      = Carbon::today()->startOfDay();
            $user       = Auth::user()->id;
        
            //Pega ambientes que vencem nos próximos 2 dias
            $prox_vencimento = Carbon::today()->addDays('2');

            $tec_responsavel = BlocoTecnico::where('user_id', $user)->pluck('bloco_id');

            $atv_n1 = RevisaoAmbienteAtividade::where('nivel', 'Nível 1')->value('atividades');  
            $atv_n2 = RevisaoAmbienteAtividade::where('nivel', 'Nível 2')->value('atividades'); 
            $atv_n3 = RevisaoAmbienteAtividade::where('nivel', 'Nível 3')->value('atividades'); 

            $ambientes = Ambiente::whereNull('status')
            ->whereIn('bloco_id', $tec_responsavel)
            ->where(function ($query ) use ($prox_vencimento, $today) {
                $query->whereBetween('prox_revisao_1', [$today, $prox_vencimento])
                ->orWhereBetween('prox_revisao_2', [$today, $prox_vencimento])
                ->orWhereBetween('prox_revisao_3', [$today, $prox_vencimento]);
            })->get();

            return view ('ambiente.index', compact('ambientes', 'unidades', 'atv_n1', 'atv_n2', 'atv_n3'));
        }

        public function revisao_vencida()
        {
            if(auth()->user()->can('Visualizar Ambientes'))
            {
                $unidades       = Unidade::all()->pluck('name', 'id');
                $today          = Carbon::today()->startOfDay();
                $tomorrow       = Carbon::tomorrow()->startOfDay();
                $aftertomorrow  = Carbon::tomorrow()->endOfDay();
                $user           = Auth::user()->id;
            
                //Pega ambientes que vencem nos próximos 2 dias
                $prox_vencimento = Carbon::today()->addDays('2');

                $tec_responsavel = BlocoTecnico::where('user_id', $user)->pluck('bloco_id');

                $atv_n1 = RevisaoAmbienteAtividade::where('nivel', 'Nível 1')->value('atividades');  
                $atv_n2 = RevisaoAmbienteAtividade::where('nivel', 'Nível 2')->value('atividades'); 
                $atv_n3 = RevisaoAmbienteAtividade::where('nivel', 'Nível 3')->value('atividades'); 

                $ambientes = Ambiente::whereNull('status')
                ->whereIn('bloco_id', $tec_responsavel)
                ->where(function ($query ) use ($today) {
                    $query->where('prox_revisao_1', '<', $today)
                    ->orWhere('prox_revisao_2', '<', $today)
                    ->orWhere('prox_revisao_3', '<', $today);
                })->get();

                return view ('ambiente.index', compact('ambientes', 'unidades', 'tomorrow', 'aftertomorrow', 'atv_n1', 'atv_n2', 'atv_n3'));
            }
            else
            {
                return view('errors.401');
            }  
        }

        public function revisao_vence_hoje()
        {
            if(auth()->user()->can('Visualizar Ambientes'))
            {
                $unidades        = Unidade::all()->pluck('name', 'id');
                $today           = Carbon::today()->startOfDay();
                $end_today       = Carbon::today()->endOfDay();
                $tomorrow        = Carbon::tomorrow()->startOfDay();
                $aftertomorrow   = Carbon::tomorrow()->endOfDay();
                $user            = Auth::user()->id;

                $atv_n1 = RevisaoAmbienteAtividade::where('nivel', 'Nível 1')->value('atividades');  
                $atv_n2 = RevisaoAmbienteAtividade::where('nivel', 'Nível 2')->value('atividades'); 
                $atv_n3 = RevisaoAmbienteAtividade::where('nivel', 'Nível 3')->value('atividades'); 

                //Pega ambientes que vencem nos próximos 2 dias
                $prox_vencimento = Carbon::today()->startOfDay()->addDays('');

                $tec_responsavel = BlocoTecnico::where('user_id', $user)->pluck('bloco_id');

                $ambientes = Ambiente::whereNull('status')
                ->whereIn('bloco_id', $tec_responsavel)
                ->where(function($query) use ($today, $end_today)
                {
                    $query  ->whereBetween('prox_revisao_1', [$today, $end_today])
                    ->orwhereBetween('prox_revisao_2', [$today, $end_today])
                    ->orwhereBetween('prox_revisao_3', [$today, $end_today]);
                })
                ->get();

                return view ('ambiente.index', compact('ambientes', 'unidades', 'tomorrow', 'aftertomorrow', 'atv_n1', 'atv_n2', 'atv_n3'));
            }
            else
            {
                return view('errors.401');
            }  
        }

        public function revisao_vence_amanha()
        {
            if(auth()->user()->can('Visualizar Ambientes'))
            {
                $unidades        = Unidade::all()->pluck('name', 'id');
                $today           = Carbon::today();
                $tomorrow        = Carbon::tomorrow()->startOfDay();
                $aftertomorrow   = Carbon::tomorrow()->endOfDay();
                $user            = Auth::user()->id;

                $atv_n1 = RevisaoAmbienteAtividade::where('nivel', 'Nível 1')->value('atividades');  
                $atv_n2 = RevisaoAmbienteAtividade::where('nivel', 'Nível 2')->value('atividades'); 
                $atv_n3 = RevisaoAmbienteAtividade::where('nivel', 'Nível 3')->value('atividades'); 

                //Pega ambientes que vencem nos próximos 2 dias
                $prox_vencimento = Carbon::today()->addDays('2');

                $tec_responsavel = BlocoTecnico::where('user_id', $user)->pluck('bloco_id');

                $ambientes = Ambiente::whereNull('status')
                ->whereIn('bloco_id', $tec_responsavel)
                ->where(function($query) use ($tomorrow, $aftertomorrow)
                {
                    $query->whereBetween('prox_revisao_1', [$tomorrow, $aftertomorrow])
                    ->orwhereBetween('prox_revisao_2', [$tomorrow, $aftertomorrow])
                    ->orwhereBetween('prox_revisao_3', [$tomorrow, $aftertomorrow]);
                })
                ->get();

                return view ('ambiente.index', compact('ambientes', 'unidades', 'tomorrow', 'aftertomorrow', 'atv_n1', 'atv_n2', 'atv_n3'));
            }
            else
            {
                return view('errors.401');
            }  
        }

        public function alterar_vencimento(Ambiente $ambiente){
            if(auth()->user()->can('Editar Vencimentos')){

                return view('ambiente.alterar_vencimento');
            }
            else
            {
                return view('errors.401');
            }  
        }

        public function update_vencimento(Request $request, Ambiente $ambiente){
            if(auth()->user()->can('Editar Vencimentos'))
            {
                $ambiente   = Input::all();
                $tipo_amb   = Input::get('tipo');
                $nivel      = Input::get('nivel');

            //Pega intervalo de datas
            /*
            $start = Carbon::createFromFormat('d/m/Y', $ambiente['start']);
            $end   = Carbon::createFromFormat('d/m/Y', $ambiente['end']);
            */

            $start = Carbon::createFromFormat('d/m/Y', $ambiente['start'])->startOfDay();
            $end   = Carbon::createFromFormat('d/m/Y', $ambiente['end']);

            //Pega último dia do input e adiciona 1 dia
            $add_day = $end->addDay('1')->addMinutes('1');

            if ($start < $end)
            {
                //Altera data de vencimento dos ambientes por tipo dentro do intervalo de datas
                if (Input::has('tipo')){               

                    if ($nivel == "Nível 1")
                    {
                        $rev_n1 = Ambiente::where('tipo', $tipo_amb)
                        ->whereBetween('prox_revisao_1', [$start, $end]);

                        $count_amb_interval = $rev_n1->count();

                        foreach($rev_n1->get() as $value){
                            $log_info = Auth::user()->name . ' alterou a data de vencimento da revisão de Nível 1 da(o) '. $value->name . ' (' . $value->sala . '), do Bloco '.$value->bloco->name.', Unidade '.$value->unidade->name.'. Que possuía vencimento em '. date('d/m/Y', strtotime($value->prox_revisao_1)) . ', para o dia '.$end->format('d/m/Y').'. ';

                            activity('Alerta')->log($log_info);

                        }

                        $update_n1 = $rev_n1->update(['prox_revisao_1' => $add_day]);

                        if($count_amb_interval > 0){
                            toastr()->success('Datas de vencimento Nível 1 atualizadas com sucesso!', 'OK', ['timeOut' => 5000]);
                        }
                        else{
                            toastr()->info('Nenhum ambiente encontrado neste intervalo de datas!', 'ATENÇÃO', ['timeOut' => 5000]);
                        }
                    }
                    else if ($nivel == "Nível 2")
                    {
                        $rev_n2 = Ambiente::where('tipo', $tipo_amb)
                        ->whereBetween('prox_revisao_2', [$start, $end]);

                        $count_amb_interval = $rev_n2->count();

                        foreach($rev_n2->get() as $value){
                            $log_info = Auth::user()->name . ' alterou a data de vencimento da revisão de Nível 1 da(o) '. $value->name . ' (' . $value->sala . '), do Bloco '.$value->bloco->name.', Unidade '.$value->unidade->name.'. Que possuía vencimento em '. date('d/m/Y', strtotime($value->prox_revisao_2)) . ', para o dia '.$end->format('d/m/Y').'. ';

                            activity('Alerta')->log($log_info);

                        }

                        $update_n2 = $rev_n2->update(['prox_revisao_2' => $add_day]);

                        if($count_amb_interval > 0){

                            toastr()->success('Datas de vencimento Nível 2 atualizadas com sucesso!', 'OK', ['timeOut' => 5000]);
                        }
                        else{
                            toastr()->info('Nenhum ambiente encontrado neste intervalo de datas!', 'ATENÇÃO', ['timeOut' => 5000]);
                        }
                    }
                    else if ($nivel == "Nível 3")
                    {
                        $rev_n3 = Ambiente::where('tipo', $tipo_amb)
                        ->whereBetween('prox_revisao_3', [$start, $end]);

                        $count_amb_interval = $rev_n3->count();

                        foreach($rev_n3->get() as $value){
                            $log_info = Auth::user()->name . ' alterou a data de vencimento da revisão de Nível 1 da(o) '. $value->name . ' (' . $value->sala . '), do Bloco '.$value->bloco->name.', Unidade '.$value->unidade->name.'. Que possuía vencimento em '. date('d/m/Y', strtotime($value->prox_revisao_3)) . ', para o dia '.$end->format('d/m/Y').'. ';

                            activity('Alerta')->log($log_info);

                        }
                    
                        $update_n3 = $rev_n3->update(['prox_revisao_3' => $add_day]);

                        if($count_amb_interval > 0){

                            toastr()->success('Datas de vencimento Nível 3 atualizadas com sucesso!', 'OK', ['timeOut' => 5000]);
                        }
                        else{
                            toastr()->info('Nenhum ambiente encontrado neste intervalo de datas!', 'ATENÇÃO', ['timeOut' => 5000]);
                        }
                    }                    
                }
                else 
                {
                        // Conta a quantidade de ambientes que estão no intervalo
                        $count_amb_interval = Ambiente::whereBetween('prox_revisao_1', [$start, $end])
                        ->orwhereBetween('prox_revisao_2', [$start, $end])
                        ->orwhereBetween('prox_revisao_3', [$start, $end])
                        ->count();

                            $n1 = Ambiente::whereBetween('prox_revisao_1', [$start, $end]);            

                            $n2 = Ambiente::whereBetween('prox_revisao_2', [$start, $end]);

                            $n3 = Ambiente::whereBetween('prox_revisao_3', [$start, $end]);

                        // Salva Log
                        foreach($n1->get() as $value){
                            $log_info = Auth::user()->name . ' alterou a data de vencimento da revisão de Nível 1 da(o) '. $value->name . ' (' . $value->sala . '), do Bloco '.$value->bloco->name.', Unidade '.$value->unidade->name.'. Que possuía vencimento em '. date('d/m/Y', strtotime($value->prox_revisao_1)) . ', para o dia '.$end->format('d/m/Y').'.';

                            activity('Alerta')->log($log_info);

                        }

                        foreach($n2->get() as $value){
                            $log_info = Auth::user()->name . ' alterou a data de vencimento da revisão de Nível 1 da(o) '. $value->name . ' (' . $value->sala . '), do Bloco '.$value->bloco->name.', Unidade '.$value->unidade->name.'. Que possuía vencimento em '. date('d/m/Y', strtotime($value->prox_revisao_2)) . ', para o dia '.$end->format('d/m/Y').'.';

                            activity('Alerta')->log($log_info);

                        }

                        foreach($n3->get() as $value){
                            $log_info = Auth::user()->name . ' alterou a data de vencimento da revisão de Nível 1 da(o) '. $value->name . ' (' . $value->sala . '), do Bloco '.$value->bloco->name.', Unidade '.$value->unidade->name.'. Que possuía vencimento em '. date('d/m/Y', strtotime($value->prox_revisao_3)) . ', para o dia '.$end->format('d/m/Y').'.';

                            activity('Alerta')->log($log_info);

                        }
                            
                            // Atualiza as datas de vencimento de todos os ambientes
                            $update_n1 = $n1->update(['prox_revisao_1' => $add_day]);
                            $update_n2 = $n2->update(['prox_revisao_2' => $add_day]);
                            $update_n3 = $n3->update(['prox_revisao_3' => $add_day]);

                        // Filtra ambientes dentro do intervalo de datas
                        if($count_amb_interval > 0){

                            toastr()->success('Datas de vencimento atualizadas com sucesso!', 'OK', ['timeOut' => 5000]);
                        }
                        else{
                            toastr()->info('Nenhum ambiente encontrado neste intervalo de datas!', 'ATENÇÃO', ['timeOut' => 5000]);
                        }
                    }
                        return redirect()->route('ambiente.alterar_vencimento');
                    }        
                    else
                    {
                        toastr()->error('A data inicial é maior que a data final!', 'ERROR', ['timeOut' => 5000]);
                        return redirect()->back();
                    }
                }
                else
                {
                    return view('errors.401');
                }  
            }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        if(auth()->user()->can('Criar Ambientes'))
        {
            $unidades           = DB::table("unidades")->pluck("name","id");
            $blocos             = Bloco::all();
            $bloco              = Bloco::all()->pluck('bloco');
            // Calcula periodo de revisão do ambiente inserido

            $get_days_1         = input::get('periodo_revisao_1');
            $calc_revisao_1     = Carbon::today()->addDays('get_days_1');

            $get_days_2         = input::get('periodo_revisao_2');
            $calc_revisao_2     = Carbon::today()->addDays('get_days_2');

            $get_days_3         = input::get('periodo_revisao_3');
            $calc_revisao_3     = Carbon::today()->addDays('get_days_3');

            $imagens            = Imagem::orderBy('image_name')->get();

            return view('ambiente.create',compact('unidades','blocos','imagens'));
        }
        else
        {
            return view('errors.401');
        }  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       //validate post data
        if(auth()->user()->can('Criar Ambientes'))
        {
            $this->validate($request, [
                'unidade_id'    => 'required',
                'bloco_id'      => 'required',
                'name'          => 'required',
                'tipo'          => 'required'
            ]);

            //insert post data
            $get_days_1 = $this->request->input('periodo_revisao_1'); 
            if($request->input('periodo_revisao_1') != 'S/R'){
                $calc_revisao_1 = Carbon::today()->addDays($get_days_1);
            }
            else
            {
                $calc_revisao_1 = null;
            }

            $get_days_2 = $this->request->input('periodo_revisao_2'); 
            if($request->input('periodo_revisao_2') != 'S/R'){
                $calc_revisao_2 = Carbon::today()->addDays($get_days_2);
            }
            else
            {
                $calc_revisao_2 = null;
            }

            $get_days_3 = $this->request->input('periodo_revisao_3'); 
            if($request->input('periodo_revisao_3') != 'S/R'){
                $calc_revisao_3 = Carbon::today()->addDays($get_days_3);
            }
            else
            {
                $calc_revisao_3 = null;
            }

            // Define a quantidade de máquinas 0 caso o ambiente não possua hardware
            if($request->input('hard_off') == true)
            {
                $request->qt_maquinas = 0;
            }

            // Verifica se os inputs de imagem estão corretos
            if($request->input('img_off') == true && $request->input('imagem_id') == null)
            {
                $request->imagem_id = 0;
            }
            else
            {
                $request->imagem_id = $request->input('imagem_id');
            }

            // Define 0 em hv_printer caso o ambiente não possua impressora
            if($request->input('print_off') == true )
            {
                $request->hv_printer = 0;
            }


            Ambiente::create($request->all() + ['prox_revisao_1' => $calc_revisao_1, 'prox_revisao_2' => $calc_revisao_2, 'prox_revisao_3' => $calc_revisao_3]);

            toastr()->success('Ambiente registrado com sucesso!', 'OK', ['timeOut' => 5000]);
            return redirect()->route('ambiente.index');
        }
        else
        {
            return view('errors.401');
        }   

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ambiente  $ambiente
     * @return \Illuminate\Http\Response
     */
    public function show(Ambiente $ambiente)
    {
        //
        if(auth()->user()->can('Visualizar Ambientes'))
        {
            $softwares  = Software::where('imagem_id', $ambiente->imagem_id)
                            ->get();

            $projetor   = Projetor::where('ambiente_id', $ambiente->id)
                            ->get();

            $impressora = Impressora::where('ambiente_id', $ambiente->id)
                            ->get();

            return view('ambiente.show',compact('ambiente','softwares', 'projetor', 'impressora'));
        }
        else
        {
            return view('errors.401');
        }  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ambiente  $ambiente
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Ambiente $ambiente)
    {
        //
        if(auth()->user()->can('Editar Ambientes') || auth()->user()->can('Visualizar Ambientes'))
        {
            $imagens    = Imagem::orderBy('image_name')->get();

            return view('ambiente.edit',compact('ambiente','imagens'));
        }
        else
        {
            return view('errors.401');
        }  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ambiente  $ambiente
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request, Ambiente $ambiente)
    {
        $ambiente = Ambiente::where('id', $id);

        if(auth()->user()->can('Editar Ambientes'))
        {
            if(isset($request->updt_hard))
            {                
                $last_hardware_hist     = HardwareHist::where('ambiente_id', $id)->latest()->get();

                if($request->input('qt_maquinas') != $ambiente->value('qt_maquinas') || $last_hardware_hist != null)
                {
                    $qt_maquinas = $ambiente->value('qt_maquinas');
                }else{
                    $qt_maquinas = NULL;
                }

                if(date('Y-m-d H:i:s', strtotime($request->input('aquisicao'))) != $ambiente->value('aquisicao'))
                {
                    $aquisicao = $ambiente->value('aquisicao');
                }else{
                    $aquisicao = NULL;
                }

                if($request->input('processador') != $ambiente->value('processador'))
                {
                    $processador = $ambiente->value('processador');
                }else{
                    $processador = NULL;
                }

                if($request->input('ram') != $ambiente->value('ram'))
                {
                    $ram = $ambiente->value('ram');
                }else{
                    $ram = NULL;
                }

                if($request->input('hd') != $ambiente->value('hd'))
                {
                    $hd = $ambiente->value('hd');
                }else{
                    $hd = NULL;
                }

                if($request->input('gpu') != $ambiente->value('gpu'))
                {
                    $gpu = $ambiente->value('gpu');
                }else{
                    $gpu = NULL;
                }

                if($request->input('gpu_memo') != $ambiente->value('gpu_memo'))
                {
                    $gpu_memo = $ambiente->value('gpu_memo');
                }else{
                    $gpu_memo = NULL;
                }

                if($request->input('gabinete') != $ambiente->value('gabinete'))
                {
                    $gabinete = $ambiente->value('gabinete');
                }else{
                    $gabinete = NULL;
                }

                if( $qt_maquinas    != null ||
                    $aquisicao      != null ||
                    $processador    != null ||
                    $ram            != null ||
                    $hd             != null ||
                    $gpu            != null ||
                    $gpu_memo       != null ||
                    $gabinete       != null){
                HardwareHist::create([
                        'user_id'           => Auth::user()->id,
                        'ambiente_id'       => $id,
                        'qt_maquinas'       => $qt_maquinas,
                        'aquisicao'         => $aquisicao,
                        'processador'       => $processador,
                        'ram'               => $ram,
                        'hd'                => $hd,
                        'gpu'               => $gpu,
                        'gpu_memo'          => $gpu_memo,
                        'gabinete'          => $gabinete,

                    ]);
                    foreach($ambiente->get() as $value){
                        $log_info = Auth::user()->name . ' atualizou o hardware do ambiente '. $value->name . ' (' . $value->sala . '), do Bloco '.$value->bloco->name.', Unidade '.$value->unidade->name.'.';

                        activity('Info')->log($log_info);
                    }
                }
                else{
                    toastr()->info('Nenhum dado para atualizar', 'Hardware', ['timeOut' => 5000]);
                }
            }else{
                foreach($ambiente->get() as $value){
                    $log_info = Auth::user()->name . ' atualizou o ambiente '. $value->name . ' (' . $value->sala . '), do Bloco '.$value->bloco->name.', Unidade '.$value->unidade->name.' sem atualizar o hardware.';

                    activity('Alerta')->log($log_info);
                }
            }

            // Atualiza os valores no DB
            $ambiente                           = Input::all();
            $ambienteUpdate                     = Ambiente::find($id);
            $ambienteUpdate->sala               = $ambiente['sala'];
            $ambienteUpdate->tipo               = $ambiente['tipo'];
            $ambienteUpdate->periodo_revisao_1  = $ambiente['periodo_revisao_1'];
            $ambienteUpdate->periodo_revisao_2  = $ambiente['periodo_revisao_2'];
            $ambienteUpdate->periodo_revisao_3  = $ambiente['periodo_revisao_3'];

            if($request->input('hard_off') == true)
            {
                $ambienteUpdate->gabinete       = 0;
                $ambienteUpdate->qt_maquinas    = 0;
                $ambienteUpdate->aquisicao      = 0;
                $ambienteUpdate->processador    = 0;
                $ambienteUpdate->ram            = 0;
                $ambienteUpdate->hd             = 0;
                $ambienteUpdate->gpu            = 0;
                $ambienteUpdate->gpu_memo       = 0;
            }else
            {
                $ambienteUpdate->gabinete       = $ambiente['gabinete'];
                $ambienteUpdate->qt_maquinas    = $ambiente['qt_maquinas'];
                $ambienteUpdate->aquisicao      = $ambiente['aquisicao'];
                $ambienteUpdate->processador    = $ambiente['processador'];
                $ambienteUpdate->ram            = $ambiente['ram'];
                $ambienteUpdate->hd             = $ambiente['hd'];
                $ambienteUpdate->gpu            = $ambiente['gpu'];
                $ambienteUpdate->gpu_memo       = $ambiente['gpu_memo'];
            }  

            //IMAGEM - Verifica se os inputs são válidos
            if ($request->input('img_off') == true)
            {
                $ambienteUpdate->imagem_id      = 0;
            }else{
                if(Input::has('imagem_id'))
                {
                    $ambienteUpdate->imagem_id  = $ambiente['imagem_id'];
                }
                else
                {
                    throw ValidationException::withMessages(['imagem_id' => 'Selecione a imagem instalada no ambiente. ']);
                }               
            }

            //PROJETOR - Verifica se os inputs são válidos
            if($request->input('proj_off') == true && Projetor::where('ambiente_id', $id)->count() == 0)
            {
                $ambienteUpdate->hv_proj        = 0;
            }
            else if($request->input('proj_off') == true && Projetor::where('ambiente_id', $id )->count() > 0)
            {
               throw ValidationException::withMessages(['proj_off' => 'Há um projetor cadastrado para esse ambiente! Para definir o ambiente como "Sem Projetor" exclua-o do sistema antes. ']);
            }
            else
            {
                $ambienteUpdate->hv_proj        = 1;            
            }

            //IMPRESSORA - Verifica se os inputs são válidos
            if($request->input('imp_off') == true && Impressora::where('ambiente_id', $id)->count() == 0)
            {
                $ambienteUpdate->hv_printer     = 0;
            }
            else if($request->input('imp_off') == true && Impressora::where('ambiente_id', $id )->count() > 0)
            {
               throw ValidationException::withMessages(['imp_off' => 'Há uma impressora cadastrada para esse ambiente! Para definir o ambiente como "Sem Impressora" exclua-a do sistema antes. ']);
            }
            else{
                $ambienteUpdate->hv_printer     = 1;
            }


            $ambienteUpdate->save();  


            toastr()->success('Ambiente atualizado com sucesso!', 'OK', ['timeOut' => 5000]);
            return redirect()->route('ambiente.index');
        }
        elseif(auth()->user()->can('Visualizar Ambientes') )
        {
            HardwareHist::create([
                'user_id'           => Auth::user()->id,
                'ambiente_id'       => $id,
                'qt_maquinas'       => $ambiente->value('qt_maquinas')
            ]);
            foreach($ambiente->get() as $value){
                $log_info = Auth::user()->name . ' atualizou o hardware do ambiente '. $value->name . ' (' . $value->sala . '), do Bloco '.$value->bloco->name.', Unidade '.$value->unidade->name.'.';

                activity('Info')->log($log_info);
            }

            $ambiente                       = Input::all();
            $ambienteUpdate                 = Ambiente::find($id);
            $ambienteUpdate->qt_maquinas    = $ambiente['qt_maquinas'];
            $ambienteUpdate->save();  

            toastr()->success('Ambiente atualizado com sucesso!', 'OK', ['timeOut' => 5000]);
            return redirect()->route('ambiente.index');
        }
        else
        {
            return view('errors.401');
        }  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ambiente  $ambiente
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request, Ambiente $ambiente)
    {
        //
        if(auth()->user()->can('Remover Ambientes')){
            $ambiente               = Ambiente::find($id);
            $ambienteUpdate         = $ambiente;
            $ambienteUpdate->status = 0;
            $ambienteUpdate->save();      

            toastr()->success('Sala '.$ambiente->sala.' do Bloco '.$ambiente->bloco->name.' Unidade '.$ambiente->unidade->name.', desabilitado com sucesso!', 'OK', ['timeOut' => 10000]);
            return redirect()->route('ambiente.index');
        }
        else
        {
            return view('errors.401');
        }   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ambiente  $ambiente
     * @return \Illuminate\Http\Response
     */
    public function active($id, Request $request, Ambiente $ambiente)
    {
        //
        if(auth()->user()->can('Remover Ambientes')){
            $ambiente               = Ambiente::find($id);
            $ambienteUpdate         = $ambiente;
            $ambienteUpdate->status = null;
            $ambienteUpdate->save();      

            toastr()->success('Sala '.$ambiente->sala.' do Bloco '.$ambiente->bloco->name.' Unidade '.$ambiente->unidade->name.', habilitado com sucesso!', 'OK', ['timeOut' => 10000]);
            return redirect()->route('ambiente.index');
        }
        else
        {
            return view('errors.401');
        }   
    }

    public function getBlocoRev(Request $request)
    {
        /*
        $blocos     = DB::table("blocos")
                        ->where('unidade_id', $request->unidade_id)
                        ->orderBy('name', 'ASC')
                        ->pluck('name','id');
        */

        $blocos     = DB::table("blocos")
                        ->where('unidade_id', $request->unidade_id)
                        ->orderBy('name','asc')
                        ->select('blocos.name as namebloco',
                                'blocos.id as id')->pluck('namebloco', 'id');

          
        return response()->json($blocos);
    }

    // Busca somente ambientes que possuem data de revisão
    public function getAmbienteRev(Request $request)
    {   

        $ambientes  = DB::table("ambientes")
                        ->where('bloco_id',$request->bloco_id)
                        ->select([
                            DB::raw('ambientes.sala as sala'),
                                'ambientes.prox_revisao_1 as prox_revisao_1', 
                                'ambientes.prox_revisao_2 as prox_revisao_2', 
                                'ambientes.prox_revisao_3 as prox_revisao_3',
                                'ambientes.id as id',
                                'ambientes.status as status',
                                'ambientes.bloco_id as bloco_id',
                                 DB::raw('ambientes.name as name'),
                                 DB::raw('CONCAT(ambientes.sala," - ",ambientes.name) AS namesala'),'id'
                       ] )                        
                        ->whereNull('status')
                        ->where('periodo_revisao_1','!=', '0')
                        ->where('periodo_revisao_2','!=', '0')
                        ->where('periodo_revisao_3','!=', '0')

                        ->orderBy('namesala','asc')

                        ->pluck('namesala', 'id');

        return response()->json($ambientes);
    }

    // Busca somente ambientes administrativos
    public function getAmbienteADM(Request $request)
    {        
        

        $ambientes  = DB::table("ambientes")
                        ->where('bloco_id',$request->bloco_id)
                        ->whereNull('status')
                        ->where('periodo_revisao_1', '0')
                        ->where('periodo_revisao_2', '0')
                        ->where('periodo_revisao_3', '0')
                        ->orderBy('sala', 'ASC')
                        ->pluck(DB::raw('CONCAT(sala," - ",name) AS name'),'id');


            //return response()->json($ambientes->values());
        return response()->json($ambientes);
    }

    // Busca todos os ambientes 
    public function getAmbienteAll(Request $request)
    {        
        $ambientes  = DB::table("ambientes")
                        ->where('bloco_id',$request->bloco_id)
                        ->whereNull('status')
                        ->orderBy('sala', 'ASC')
                        ->pluck(DB::raw('CONCAT(sala," - ",name) AS name'),'id');

            //return response()->json($ambientes->values());
        return response()->json($ambientes);
    }

    public function setOptionsAttribute($application)
    {
        $this->attributes['application'] = json_encode($application);
    }

    public function generate_print_software($id, Request $request) 
    {

        $ambiente       = Ambiente::find($id);

        $softwares      = Software::orderBy('application')
                            ->where('imagem_id', $ambiente->imagem_id)
                            ->get();

        $qt_software    = Software::orderBy('application')
                            ->where('imagem_id', $ambiente->imagem_id)
                            ->count();


        $centered       = array('align' => 'center');
        $noSpace        = array('spaceAfter' => 0);

        $my_template    = new \PhpOffice\PhpWord\TemplateProcessor(public_path("doc\ambiente_software.docx"));

        $my_template->setValue('nome_do_ambiente', $ambiente->name);

        $my_template->setValue('qt_maquinas', $ambiente->qt_maquinas);
        $my_template->setValue('proc', $ambiente->processador);
        $my_template->setValue('memo', $ambiente->ram);
        /*
            $my_template->setValue('software', $ambiente->name);
            $my_template->setValue('version', $ambiente->name);
        */


        $table              = new Table(array(
            'borderSize'    => 8, 
            'borderColor'   => 'gray', 
            'width'         => 10000, 
            'unit'          => TblWidth::TWIP, 
            'cellSpacing '  => 0,

        ));

        $table->addRow(200,null);
        $table->addCell(8000)->addText('Software', array('bold'=>true), $noSpace);
        $table->addCell(2000)->addText('Versão', array('bold'=>true), $noSpace);

        foreach ($softwares as  $data) {
        # code...

           $table->addRow();
           $table->addCell(200)->addText(htmlspecialchars("{$data->application}"), array('size' => 9), $noSpace);
           $table->addCell(200)->addText(htmlspecialchars("{$data->app_version} "), array('size' => 9), $noSpace);

        }

        $my_template->setComplexBlock('table', $table);

        try{
            $my_template->saveAs(public_path('doc\temp\Softwares - '. $ambiente->name . '.docx'));
        }catch (Exception $e){
                //handle exception
        }

        return response()->download(public_path('doc\temp\Softwares - '. $ambiente->name . '.docx'));

        unlink($my_template);  // remove temp file
    }

}
