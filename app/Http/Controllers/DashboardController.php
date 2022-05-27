<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Software;
use App\Models\SoftwareList;
use App\Models\SoftwareKey;
use App\Models\Hardware;
use App\Models\Imagem;
use App\Models\OuMachines;
use App\Models\Ambiente;
use App\Models\Mip;
use App\Models\RevisaoAmbiente;
use App\Models\Projetor;
use App\Models\BlocoTecnico;
use App\Models\Impressora;
use App\Models\User;
use Auth, DB;
use Carbon\Carbon;
use Session;

class DashboardController extends Controller
{
    protected   $request;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Atualiza banco com horário do último login
        $loginUpdate = User::find(Auth::user()->id);
        $loginUpdate->last_login_at = Carbon::now()->toDateTimeString();
        $loginUpdate->last_login_ip = $request->getClientIp();
        $loginUpdate->update();

        $today           = Carbon::today()->startOfDay();
        $end_today       = Carbon::today()->endOfDay();
        $tomorrow        = Carbon::tomorrow()->startOfDay();
        $aftertomorrow   = Carbon::tomorrow()->endOfDay();
        $user            = Auth::user()->id;

        $tec_responsavel = BlocoTecnico::where('user_id', $user)->pluck('bloco_id');
        $mes_passado     = date('n') - 1;               
        $now             = Carbon::now();

        $qt_ambientes    = Ambiente::whereNull('status')->count();
        
        $qt_projetores   = Projetor::count();  

        $qt_impressoras  = Impressora::count(); 

        $qt_softwares    = SoftwareList::count(); 

        $qt_softwares_lic = SoftwareKey::whereNull('status')->count();

        $qt_imagens      = Imagem::distinct('image_name')->count('image_name');

        $qt_users_ativos = User::where('status', 1)->count();

        $qt_revisao_mes  = RevisaoAmbiente::where(DB::raw('MONTH(created_at)'), '=', date('n'))
            ->where(DB::raw('YEAR(created_at)'), '=', date('Y'))
            ->distinct('rev_id')
            ->count('rev_id');
        
        $qt_revisao_mes_passado = RevisaoAmbiente::where(DB::raw('MONTH(created_at)'), '=', $mes_passado)
            ->where(DB::raw('YEAR(created_at)'), '=', date('Y'))
            ->distinct('rev_id')
            ->count('rev_id');
        
        //Verfica revisões vencidas
        $revisoes_vencidas = Ambiente::whereNull('status')
            ->whereIn('bloco_id', $tec_responsavel)
            ->where(function($query) use ($today)
                {
                    $query->where('prox_revisao_1', '<', $today)
                        ->orWhere('prox_revisao_2', '<', $today)
                        ->orWhere('prox_revisao_3', '<', $today);
                })
            ->count();
        
        //Verfica revisões que vencem hoje
        $revisoes_v_t = Ambiente::whereNull('status')
            ->whereIn('bloco_id', $tec_responsavel)
            ->where(function($query) use ($today, $end_today)
                {
                    $query->whereBetween('prox_revisao_1', [$today, $end_today])
                        ->orwhereBetween('prox_revisao_2', [$today, $end_today])
                        ->orwhereBetween('prox_revisao_3', [$today, $end_today]);
                })
            ->count();

        //Verfica revisões que vencem amanhã
        $revisoes_v_tp1 = Ambiente::whereNull('status')
            ->whereIn('bloco_id', $tec_responsavel)
            ->where(function($query) use ($tomorrow, $aftertomorrow)
                {
                    $query->whereBetween('prox_revisao_1', [$tomorrow, $aftertomorrow])
                        ->orwhereBetween('prox_revisao_2', [$tomorrow, $aftertomorrow])
                        ->orwhereBetween('prox_revisao_3', [$tomorrow, $aftertomorrow]);
                })
            ->count();


        //Calcula Média de SLA cumprida no mês
        $total_rev_month    = RevisaoAmbiente::whereMonth('created_at', Carbon::now()->month)
                                ->whereYear('created_at', Carbon::now()->year)
                                ->count();

        $close_ontime       = RevisaoAmbiente::whereMonth('created_at', Carbon::now()->month)
                                ->whereYear('created_at', Carbon::now()->year)
                                ->where('obs', 'LIKE', "%No Prazo.%")
                                ->count();  
                                
        if($total_rev_month > 0){
            $sla_month = $close_ontime / $total_rev_month * 100 ;
        }
        else{
            $sla_month = 100;
        }

        //Fim calculo SLA
        
        //GRÁFICOS
        //Count de revisões realizadas/vencidas
        //---
        //Geral
        /*
        $rev_graf_p = RevisaoAmbiente::select(
                DB::raw('SUM(obs LIKE "%No Prazo.%" ) as rev_p'), 
                DB::raw('SUM(obs LIKE "%após o vencimento.%") as rev_v'), 
                DB::raw('DATE_FORMAT(created_at, "%Y %m") month_year'),
                DB::raw('DATE_FORMAT(created_at, "%M - %Y") month')
            )
            ->orderBy('month_year', 'asc')
            ->groupby('month_year')
            ->limit(12)
            ->get();

        //INDICADOR HISTÓRICO SLA
        $sla_hist = RevisaoAmbiente::select(
                 DB::raw('ROUND(
                    SUM(obs LIKE "%No Prazo.%" )
                    /
                    COUNT(*)  
                    * 
                    100, 2)
                    as 
                    sla_hist
                    '),            
                DB::raw('DATE_FORMAT(created_at, "%Y %m") month_year'),
                DB::raw('DATE_FORMAT(created_at, "%M - %Y") month')
            )
            ->orderBy('month_year', 'asc')
            ->groupby('month_year')
            ->limit(12)
            ->get();
*/
        //Quantidade de Revisões Vencidas Por Bloco
        $blocos_vencidos = RevisaoAmbiente::select(
                DB::raw('blocos.id,blocos.name as blocos_count'),
                'bloco_id as bloco' ,
                DB::raw('SUM(obs LIKE "%após o vencimento.%") as rev_bloco_v')
            )
            ->join('blocos',function($q){
                    $q->on('revisao_ambientes.bloco_id', 'blocos.id');
                })
            ->whereMonth('revisao_ambientes.created_at', Carbon::now()->month) 
            ->where('obs','!=','No Prazo.')
            ->groupBy('bloco')
            ->orderBy('rev_bloco_v', 'desc')
            ->get();

        //Count de blocos que mais fecham revisões vencidas
        //Por Bloco
        $percent_revisao_bloco = RevisaoAmbiente::select(
                DB::raw('blocos.id,blocos.name as total_blocos_count'),
                'bloco_id as bloco',
                DB::raw('ROUND(
                    SUM(obs LIKE "%após o vencimento.%") 
                    / 
                    COUNT(rev_id)
                    * 
                    100, 2)
                    as 
                    percent_rev_bloco
                    ')
            )
            ->join('blocos',function($q){
                    $q->on('revisao_ambientes.bloco_id', 'blocos.id');
                })            
            ->groupBy('bloco')
            ->orderBy('percent_rev_bloco', 'desc')
            ->limit(5) 
            ->get();

        $rev_em_andamento_cnt = RevisaoAmbiente::whereNull('rev_status')->count();

        $rev_em_andamento_lst = RevisaoAmbiente::whereNull('rev_status')->get();

        //---------------------------------
        return view('dashboard.admin', compact('now', 'qt_revisao_mes', 'revisoes_vencidas', 'revisoes_v_t', 'revisoes_v_tp1', 'qt_ambientes', 'qt_projetores', 'qt_impressoras', 'sla_month', 'blocos_vencidos', 'percent_revisao_bloco', 'rev_em_andamento_cnt', 'rev_em_andamento_lst', 'qt_softwares', 'qt_softwares_lic', 'qt_imagens', 'qt_users_ativos'));
    }
    
    public function pagenotfound()
    {
        return view('errors.pagenotfound');
    }

      /**
     * Fetch the particular company details
     * @return json response
     */
      public function revHistChart()
      {
        $result = RevisaoAmbiente::select(
                 DB::raw('ROUND(
                    SUM(obs LIKE "%No Prazo.%" )
                    /
                    COUNT(*)  
                    * 
                    100, 2)
                    as 
                    sla_hist
                    '),  
                 //DB::raw('CONCAT(sla_hist_vl,"%") as sla_hist'),
                DB::raw('SUM(obs LIKE "%No Prazo.%" ) as rev_p'), 
                DB::raw('SUM(obs LIKE "%após o vencimento.%") as rev_v'),           
                DB::raw('DATE_FORMAT(created_at, "%Y %m") month_year'),
                DB::raw('DATE_FORMAT(created_at, "%m/%Y") months')
            )
            ->orderBy('month_year', 'asc')
            ->groupby('month_year')
            ->limit(12)
            ->get();


/*
$months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
$meses = array('Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');

$result = str_ireplace($months, $meses, $results);
*/

        return response()->json($result);
      }
}
