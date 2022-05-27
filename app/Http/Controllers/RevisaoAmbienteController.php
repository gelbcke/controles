<?php

namespace App\Http\Controllers;

use App\Models\Unidade;
use App\Models\Bloco;
use App\Models\Ambiente;
use App\Models\RevisaoAmbiente;
use App\Models\RevisaoAmbienteNivel;
use App\Models\RevisaoAmbienteAtividade;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as Input;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Auth, DateTime;
use Alert;
use DB;
use Carbon\Carbon;
use Carbon\CarbonInterval;

class RevisaoAmbienteController extends Controller
{

    private $revisaoambiente;
    protected   $request;

    //public $search;

    public function __construct(Request $request, RevisaoAmbiente $revisaoambiente)
    {
        $this->middleware('auth');
        $this->revisaoambiente = $revisaoambiente;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if(auth()->user()->can('Visualizar Revisão')){
            $revisoes           = RevisaoAmbiente::distinct('rev_id')
                                    ->orderby('created_at', 'desc')
                                    ->get();

            $filtro_vencidos    = 'dias após o vencimento.';
            $filtro_no_prazo    = 'No Prazo.';

            $dados              = RevisaoAmbiente::select(['rev_id','user_id','created_at','ambiente_id','bloco_id','unidade_id','obs', 'created_at', 'updated_at'])
                                    ->distinct('rev_id')
                                    ->orderby('created_at', 'desc')
                                    ->get();
            $unidades           = Unidade::pluck('name', 'id');



            $unidade    = $request->input('unidade_id');
            $bloco      = Input::get('bloco_id');
            $ambiente   = Input::get('ambiente_id');





            return view('revisao.index',compact('revisoes','dados','unidades', 'filtro_vencidos','filtro_no_prazo', 'unidade', 'bloco', 'ambiente'));
        }else{
            return view('errors.401');
        }
    }

    public function revList(Request $request)
    {
        if(auth()->user()->can('Visualizar Revisão')){
            $revisoes = DB::table('revisao_ambientes')
                ->join('unidades', 'revisao_ambientes.unidade_id', '=', 'unidades.id')
                ->join('blocos', 'revisao_ambientes.bloco_id', '=', 'blocos.id')
                ->join('ambientes', 'revisao_ambientes.ambiente_id', '=', 'ambientes.id')
                ->join('users', 'revisao_ambientes.user_id', '=', 'users.id')
                ->select([
                    'revisao_ambientes.unidade_id', 'unidades.name as unidade_name',
                    'revisao_ambientes.bloco_id', 'blocos.name as bloco_name',
                    DB::raw('CONCAT(ambientes.sala, " - ", ambientes.name) as ambiente_name'),
                    'revisao_ambientes.user_id', 'users.name as user_name',
                    'revisao_ambientes.created_at as created_at',
                    'revisao_ambientes.updated_at as updated_at',
                    'revisao_ambientes.rev_id as rev_id',
                    'revisao_ambientes.rev_status as rev_status',
                    'revisao_ambientes.nivel as nivel'
                ]);

            return datatables()->of($revisoes)
             ->editColumn('created_at', function ($revisoes)
                {
                    return date('d/m/Y H:i', strtotime($revisoes->created_at) );
                })
                ->addColumn('tmr', function($revisoes) {
                    if(($revisoes->updated_at == $revisoes->created_at) && ($revisoes->rev_status != NULL)){
                        return '<center><font>---</font></center>';
                    }
                    elseif($revisoes->rev_status != null){
                        $created_at = Carbon::parse($revisoes->created_at);
                        $updated_at = Carbon::parse($revisoes->updated_at);

                        $days       = $created_at->diffInDays($updated_at);
                        $hours      = $created_at->diffInHours($updated_at->subDays($days));
                        $minutes    = $created_at->diffInMinutes($updated_at->subHours($hours));
                        $seconds    = $created_at->diffInSeconds($updated_at->subMinutes($minutes));

                        return CarbonInterval::days($days)->hours($hours)->minutes($minutes)->seconds($seconds)->forHumans();
                    }
                    else{
                        return '<center><font color="green">Em Andamento</font></center>';
                    }
                })
                ->addColumn('detalhes', function($row) {
                    return '<a href="revisao/'. $row->rev_id .'" class="btn btn-xs btn-primary">Detalhes</a>';
                })
                ->rawColumns(['detalhes', 'tmr'])
                ->make(true);

            }else{
                return view('errors.401');
            }
        }

    public function revListMes(Request $request)
    {
        if(auth()->user()->can('Visualizar Revisão')){

            $revisoes = DB::table('revisao_ambientes')
                ->whereMonth('revisao_ambientes.created_at', Carbon::now()->format('m'))
                ->join('unidades', 'revisao_ambientes.unidade_id', '=', 'unidades.id')
                ->join('blocos', 'revisao_ambientes.bloco_id', '=', 'blocos.id')
                ->join('ambientes', 'revisao_ambientes.ambiente_id', '=', 'ambientes.id')
                ->join('users', 'revisao_ambientes.user_id', '=', 'users.id')
                ->select([
                    'revisao_ambientes.unidade_id', 'unidades.name as unidade_name',
                    'revisao_ambientes.bloco_id', 'blocos.name as bloco_name',
                    DB::raw('CONCAT(ambientes.sala, " - ", ambientes.name) as ambiente_name'),
                    'revisao_ambientes.user_id', 'users.name as user_name',
                    'revisao_ambientes.created_at as created_at',
                    'revisao_ambientes.updated_at as updated_at',
                    'revisao_ambientes.rev_id as rev_id',
                    'revisao_ambientes.rev_status as rev_status',
                    'revisao_ambientes.nivel as nivel'
                ]);

            return datatables()->of($revisoes)
                ->editColumn('created_at', function ($revisoes)
                {
                    return date('d/m/Y H:i', strtotime($revisoes->created_at) );
                })
                ->addColumn('tmr', function($revisoes) {
                    if(($revisoes->updated_at == $revisoes->created_at) && ($revisoes->rev_status != NULL)){
                        return '<center><font>---</font></center>';
                    }
                    elseif($revisoes->rev_status != null){
                        $created_at = Carbon::parse($revisoes->created_at);
                        $updated_at = Carbon::parse($revisoes->updated_at);

                        $days       = $created_at->diffInDays($updated_at);
                        $hours      = $created_at->diffInHours($updated_at->subDays($days));
                        $minutes    = $created_at->diffInMinutes($updated_at->subHours($hours));
                        $seconds    = $created_at->diffInSeconds($updated_at->subMinutes($minutes));

                        return CarbonInterval::days($days)->hours($hours)->minutes($minutes)->seconds($seconds)->forHumans();
                    }
                    else{
                        return '<center><font color="green">Em Andamento</font></center>';
                    }
                })
                ->addColumn('detalhes', function($row) {
                    return '<a href="'. $row->rev_id .'" class="btn btn-xs btn-primary">Detalhes</a>';
                })

                ->rawColumns(['detalhes', 'tmr'])
                ->make(true);

            }else{
                return view('errors.401');
            }
        }

    public function revisao_mes(Request $request)
    {
        //
        if(auth()->user()->can('Visualizar Revisão')){
            $revisoes = RevisaoAmbiente::distinct('rev_id')->orderby('created_at', 'desc')->get();
            $filtro_vencidos = 'dias após o vencimento.';
            $filtro_no_prazo = 'No Prazo.';
            $dados = RevisaoAmbiente::select(['rev_id','user_id','created_at','ambiente_id','bloco_id','unidade_id','obs'])
                ->distinct('rev_id')
                ->whereMonth('created_at', Carbon::now()->format('m'))
                ->orderby('created_at', 'desc')
                ->get();
            $unidades = Unidade::pluck('name', 'id');
            return view('revisao.index',compact('revisoes','dados','unidades', 'filtro_vencidos','filtro_no_prazo'));

        }else{
            return view('errors.401');
        }
    }

    public function filter(Request $request)
    {
        //
        if(auth()->user()->can('Visualizar Revisão')){
            $revisoes           = RevisaoAmbiente::distinct('rev_id')
                                    ->orderby('created_at', 'desc')
                                    ->get();

            $filtro_vencidos    = 'dias após o vencimento.';
            $filtro_no_prazo    = 'No Prazo.';

            $dados              = RevisaoAmbiente::select(['rev_id','user_id','created_at','ambiente_id','bloco_id','unidade_id','obs', 'created_at', 'updated_at'])
                                    ->distinct('rev_id')
                                    ->orderby('created_at', 'desc')
                                    ->get();
            $unidades           = Unidade::pluck('name', 'id');

            return view('revisao.index',compact('revisoes','dados','unidades', 'filtro_vencidos','filtro_no_prazo', 'request'));
        }else{
            return view('errors.401');
        }

    }

    public function revListFilter(Request $request, RevisaoAmbiente $revisao_ambiente)
    {
        //
        if(auth()->user()->can('Visualizar Revisão')){

            $unidades   = Unidade::pluck('name', 'id');

            $unidade    = $request->input('unidade_id');
            $bloco      = Input::get('bloco_id');
            $ambiente   = Input::get('ambiente_id');

            $filtro_vencidos = 'após o vencimento.';
            $filtro_no_prazo = 'No Prazo.';

            $revisoes = DB::table('revisao_ambientes')
                ->join('unidades', 'revisao_ambientes.unidade_id', '=', 'unidades.id')
                ->join('blocos', 'revisao_ambientes.bloco_id', '=', 'blocos.id')
                ->join('ambientes', 'revisao_ambientes.ambiente_id', '=', 'ambientes.id')
                ->join('users', 'revisao_ambientes.user_id', '=', 'users.id')
                ->select([
                    'revisao_ambientes.unidade_id', 'unidades.name as unidade_name',
                    'revisao_ambientes.bloco_id', 'blocos.name as bloco_name',
                    DB::raw('CONCAT(ambientes.sala, " - ", ambientes.name) as ambiente_name'),
                    'revisao_ambientes.user_id', 'users.name as user_name',
                    'revisao_ambientes.created_at as created_at',
                    'revisao_ambientes.updated_at as updated_at',
                    'revisao_ambientes.rev_id as rev_id',
                    'revisao_ambientes.rev_status as rev_status',
                    'revisao_ambientes.nivel as nivel'
                ])

            ->where('revisao_ambientes.unidade_id', $unidade)

            ->when(Input::get('bloco_id') != null, function ($revisoes) use ($bloco) {
                $revisoes->where('revisao_ambientes.bloco_id', $bloco);
            })

            ->when(Input::get('ambiente_id') != null, function ($revisoes) use ($ambiente) {
                $revisoes->where('revisao_ambientes.ambiente_id', $ambiente);
            });

            if ($request->has('somente_vencidos'))
            {
                $dados = $revisoes->where('revisao_ambientes.obs', 'LIKE', '%' .$filtro_vencidos. '%')->get();
            }
            else if ($request->has('somente_no_prazo'))
            {
                $dados = $revisoes->where('revisao_ambientes.obs', $filtro_no_prazo)->get();
            }
            else
            {
                $dados = $revisoes->get();
            }

            return datatables()->of($revisoes)
             ->editColumn('created_at', function ($revisoes)
                {
                    return date('d/m/Y H:i', strtotime($revisoes->created_at) );
                })
                ->addColumn('tmr', function($revisoes) {
                    if(($revisoes->updated_at == $revisoes->created_at) && ($revisoes->rev_status != NULL)){
                        return '<center><font>---</font></center>';
                    }
                    elseif($revisoes->rev_status != null){
                        $created_at = Carbon::parse($revisoes->created_at);
                        $updated_at = Carbon::parse($revisoes->updated_at);

                        $days       = $created_at->diffInDays($updated_at);
                        $hours      = $created_at->diffInHours($updated_at->subDays($days));
                        $minutes    = $created_at->diffInMinutes($updated_at->subHours($hours));
                        $seconds    = $created_at->diffInSeconds($updated_at->subMinutes($minutes));

                        return CarbonInterval::days($days)->hours($hours)->minutes($minutes)->seconds($seconds)->forHumans();
                    }
                    else{
                        return '<center><font color="green">Em Andamento</font></center>';
                    }
                })
                ->addColumn('detalhes', function($row) {
                    return '<a href="'. $row->rev_id .'" class="btn btn-xs btn-primary">Detalhes</a>';
                })
                ->rawColumns(['detalhes', 'tmr'])
                ->make(true);

            }else{
                return view('errors.401');
            }
    }

    public function revisao_vencidas()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        if(auth()->user()->can('Criar Revisão')){

            $user_id    = Auth::user()->id;
            $now        = Carbon::now();

            $check_rev = RevisaoAmbiente::whereNull('rev_status')
                ->where('user_id', $user_id)
                ->where('nivel', '!=', 'Nível 3')
                ->count();

            $check_n3 = RevisaoAmbiente::whereNull('rev_status')
                ->where('user_id', $user_id)
                ->where('nivel', 'Nível 3')
                ->count();

            $revs_n3 = RevisaoAmbiente::whereNull('rev_status')
                ->where('user_id', $user_id)
                ->where('nivel', 'Nível 3')
                ->get();

            if($check_rev > 0){
                $user_id    = Auth::user()->id;

                $my_rev     = RevisaoAmbiente::where('user_id', $user_id)
                ->wherenull('rev_status')
                ->orderby('nivel', 'asc')
                ->get();

                $now        = Carbon::now();

                return view('revisao.close', compact('my_rev', 'now'));

            }
            else{
               $today = Carbon::today()
                    ->toDateTimeString();

                $unidades = DB::table("unidades")
                    ->pluck("name","id");

                $niveis = RevisaoAmbienteAtividade::where('atividades', '!=' ,'null')
                    ->orderby('id','asc')
                    ->get();

                $serv_status = RevisaoAmbienteAtividade::where('atividades', '!=' ,'null')
                    ->count();

                $participantes = User::where('status', 1)
                    ->where('id', '!=', $user_id)
                    ->where('status', '!=', 0)
                    ->orderBy('name', 'asc')
                    ->get();

                return view('revisao.create',compact('unidades','niveis','serv_status','participantes', 'check_n3','revs_n3', 'now'));

            }
        }
        else{
            return view('errors.401');
        }
    }

    public function rev_close($id, Request $request)
    {
        $rev = RevisaoAmbiente::find($id);
        $revUpdate = $rev;
        $revUpdate->rev_status = 'Concluído';
        $revUpdate->save();

        toastr()->success('Revisão concluída com sucesso!', 'OK', ['timeOut' => 5000]);
        return redirect()->route('revisao.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(auth()->user()->can('Criar Revisão')){
            $today          = Carbon::today();
            $atividade      = $request->input('atividades');
            $nivel          = RevisaoAmbienteAtividade::where('atividades', $atividade)->value('nivel');

            //validate post data
            $revisaoambiente = RevisaoAmbiente::get(['unidade_id', 'bloco_id', 'ambiente_id', 'atividades', 'user_id','rev_id']);

            //pega as id's da unidade, bloco e ambiente
            $id_unidade     = $request->input('unidade_id');
            $id_bloco       = $request->input('bloco_id');
            $id_ambiente    = $request->input('ambiente_id');

            //Conta revisões em andamento
            $check_rev_on   = RevisaoAmbiente::where('unidade_id', $id_unidade)->where('bloco_id', $id_bloco)->where('ambiente_id', $id_ambiente)->whereNull('rev_status')->count();

            if($id_ambiente != 0 && $id_bloco != 0 && $id_unidade != 0){

                //Se NÃO houver nenhuma revisão em andamento no ambiente, inicia a revisão!
                if($check_rev_on == 0 ){

                    // Periodo de Revisões
                    $per_1  = Ambiente::where('id', $id_ambiente)->value('periodo_revisao_1');
                    $per_2  = Ambiente::where('id', $id_ambiente)->value('periodo_revisao_2');
                    $per_3  = Ambiente::where('id', $id_ambiente)->value('periodo_revisao_3');

                    // Datas das revisões
                    $dt_1   = Ambiente::where('id', $id_ambiente)->value('prox_revisao_1');
                    $dt_2   = Ambiente::where('id', $id_ambiente)->value('prox_revisao_2');
                    $dt_3   = Ambiente::where('id', $id_ambiente)->value('prox_revisao_3');
                    $days_1 = $today->diffInDays($dt_1);
                    $days_2 = $today->diffInDays($dt_2);
                    $days_3 = $today->diffInDays($dt_3);

                    //
                    $this->validate($request, [
                        'unidade_id' => 'required',
                        'bloco_id' => 'required',
                        'ambiente_id' => 'required',
                        'atividades' => 'required',
                        'nivel' => 'required'
                    ]);

                    $revisao                = new RevisaoAmbiente;
                    $revisao->user_id       = Auth::user()->id;
                    $revisao->rev_id        = uniqid();
                    $revisao->nivel         = RevisaoAmbienteAtividade::where('atividades', $request->input('atividades'))->value('nivel');

                    $revisao->unidade_id    = $request->input('unidade_id');
                    $revisao->bloco_id      = $request->input('bloco_id');
                    $revisao->ambiente_id   = $request->input('ambiente_id');
                    $revisao->atividades    = $request->input('atividades');

                    if(!empty($request->input('participante'))) {
                        $revisao->participante = implode(', ', Input::get('participante'));
                    }

                    //Insere informação caso a revisão tenha sido realizada após o vencimento
                    if($nivel == "Nível 1" && $today->toDateTimeString() > $dt_1){
                        $revisao->obs = "Revisão Nível 1 realizada $days_1 dias após o vencimento.";
                    }
                    else if ($nivel == "Nível 2" && $today->toDateTimeString() > $dt_2){
                     $revisao->obs = "Revisão Nível 2 realizada $days_2 dias após o vencimento.";
                     }
                     else if ($nivel == "Nível 3" && $today->toDateTimeString() > $dt_3){
                         $revisao->obs = "Revisão Nível 3 realizada $days_3 dias após o vencimento.";
                     }
                     else {
                        $revisao->obs = "No Prazo.";
                    }
                    $revisao->save();

                    // Atualiza data da próxima revisão para o ambiente
                    $ambiente = Input::all();
                    $ambienteUpdate = Ambiente::find($id_ambiente);
                    if($nivel == "Nível 1"){
                         $periodo_revisao_1 = $per_1;

                        // Se a data que for salvar o próximo vencimento for um fim de semana, ele irá adiar para segunda-feira.
                        if(Carbon::today()->addDays($periodo_revisao_1)->isWeekend()){
                            $ambienteUpdate->prox_revisao_1 = Carbon::today()->addDays($periodo_revisao_1)->addWeekday();
                        }
                        else{
                            $ambienteUpdate->prox_revisao_1 = Carbon::today()->addDays($periodo_revisao_1);
                        }
                    }
                    if ($nivel == "Nível 2"){
                         $periodo_revisao_2 = $per_2;

                        // Se a data que for salvar o próximo vencimento for um fim de semana, ele irá adiar para segunda-feira.
                        if(Carbon::today()->addDays($periodo_revisao_2)->isWeekend()){
                            $ambienteUpdate->prox_revisao_2 = Carbon::today()->addDays($periodo_revisao_2)->addWeekday();
                        }
                        else{
                            $ambienteUpdate->prox_revisao_2 = Carbon::today()->addDays($periodo_revisao_2);
                        }
                    }
                    if ($nivel == "Nível 3"){
                         $periodo_revisao_3 = $per_3;

                        // Se a data que for salvar o próximo vencimento for um fim de semana, ele irá adiar para segunda-feira.
                        if(Carbon::today()->addDays($periodo_revisao_3)->isWeekend()){
                            $ambienteUpdate->prox_revisao_3 = Carbon::today()->addDays($periodo_revisao_3)->addWeekday();
                        }
                        else{
                            $ambienteUpdate->prox_revisao_3 = Carbon::today()->addDays($periodo_revisao_3);
                        }
                    }
                    $ambienteUpdate->save();
                    toastr()->success('Revisão iniciada com sucesso!', 'OK', ['timeOut' => 5000]);
                    return redirect()->route('revisao.create');

                }
                else{
                    toastr()->error('Já temos uma revisão em andamento para este ambiente!', 'ATENÇÃO!', ['timeOut' => 15000]);
                    return redirect()->route('revisao.create');
                }
            }
            else{
                toastr()->error('Não conseguimos registrar esta revisão. Tente Novamente!', 'ERRO', ['timeOut' => 15000]);
                return redirect()->route('revisao.create');
            }

        }else{
            return view('errors.401');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RevisaoAmbiente  $revisaoAmbiente
     * @return \Illuminate\Http\Response
     */
    public function show($rev_id, RevisaoAmbiente $revisaoAmbiente)
    {
        //
        if(auth()->user()->can('Visualizar Revisão')){

            $filtro_vencidos = 'dias após o vencimento.';
            $filtro_no_prazo = 'No Prazo.';


            $get_id = RevisaoAmbiente::find($rev_id);

            $ambiente = RevisaoAmbiente::where('rev_id', $rev_id)
            ->distinct('ambiente_id')
            ->get(['ambiente_id']);

            $revisao = RevisaoAmbiente::where('rev_id', $rev_id)
            ->get();

            $getunidade = $revisao->pluck('unidade_id');

            $unidade = Unidade::where('id', $getunidade)->get();

            $getbloco = $revisao->pluck('bloco_id');

            $bloco = Bloco::where('id', $getbloco)->get();

            return view('revisao.show',compact('revisao','ambiente','unidade','bloco', 'filtro_vencidos','filtro_no_prazo'));
        }else{
            return view('errors.401');
        }
    }
}
