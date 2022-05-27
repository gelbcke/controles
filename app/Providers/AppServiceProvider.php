<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Auth, View;
use Illuminate\Http\Request;
use App\Models\MyNote;
use App\Models\Ambiente;
use App\Models\BlocoTecnico;
use App\Models\SoftwareKey;
use App\Models\Alert;
use App\Models\TermosResponsabilidade;
use Carbon\Carbon;
use Session;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton(\Faker\Generator::class, function () {
            return \Faker\Factory::create('pt_BR');
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Request $request)
    {
        //
        Schema::defaultStringLength(191);

        setlocale(LC_TIME, 'pt_BR');

        Carbon::setLocale('pt_BR');

        //Faz a contagem do total de notas que o usuário tem, e atualiza o Badge

        view()->composer('*', function ($view) 
        {
            if($user = Auth::user())
            {

                $note_count         = MyNote::where('user_id', Auth::user()->id)->count();
                                    View::share('note_count', $note_count);

                $today              = Carbon::today()->startOfDay();
                $endtoday           = Carbon::today()->endOfDay();
                $next_month         = Carbon::today()->startOfDay()->addWeek(4);
                $user               = Auth::user();

                //Pega ambientes que vencem nos próximos 2 dias
                $prox_vencimento    = Carbon::today()->addDays('2');
                $tec_responsavel    = BlocoTecnico::where('user_id', $user->id)->pluck('bloco_id');

                //Alerta dos ambientes que irão vencer nos próximos 2 dias
                $alert_amb_prox_venc = Ambiente::where('status', null)
                    ->whereIn('bloco_id', $tec_responsavel)
                    ->where(function ($query) use ($prox_vencimento, $today) {
                        $query  ->whereBetween('prox_revisao_1', [$today, $prox_vencimento])
                                ->orWhereBetween('prox_revisao_2', [$today, $prox_vencimento])
                                ->orWhereBetween('prox_revisao_3',  [$today, $prox_vencimento]);
                        })
                    ->get();

                $calendar_vt = Ambiente::where('status', null)
                    ->whereIn('bloco_id', $tec_responsavel)
                    ->where(function ($query) use ($endtoday, $today) {
                        $query  ->whereBetween('prox_revisao_1', [$today, $endtoday])
                                ->orWhereBetween('prox_revisao_2', [$today, $endtoday])
                                ->orWhereBetween('prox_revisao_3',  [$today, $endtoday]);
                        })
                    ->get();

                //Alerta dos ambientes que estão vencidos
                $alert_amb_venc = Ambiente::where('status', null)
                    ->whereIn('bloco_id', $tec_responsavel)
                    ->where(function ($query) use ($today) {
                        $query  ->where('prox_revisao_1', '<' , $today)
                                ->orWhere('prox_revisao_2', '<' , $today)
                                ->orWhere('prox_revisao_3', '<' , $today);
                        })
                    ->get();

                //Alerta dos softwares que irão vencer
                $count_alert = Alert::wherenull('status')
                                    ->count();
                    
                if (Auth::user()->can('Visualizar Softwares')){
                $soft_alert = SoftwareKey::where(function ($query) use ($today, $next_month) {
                        $query  ->where('due_date', '<' , $today)
                                ->orWhereBetween('due_date', [$today, $next_month]);
                        })
					->whereNull('status')
                    ->count();
                }else{
                    $soft_alert = 0;
                }


                if (Auth::user()->can('Visualizar Termos de Responsabilidade')){
                $termo_alert = TermosResponsabilidade::where(function ($query) use ($today, $next_month) {
                        $query  ->where('dt_entrega', '<' , $today)
                                ->whereNull('status');
                        })
                    ->count();

                }else{
                    $termo_alert = 0;
                }

                $alerts = ($soft_alert + $count_alert + $termo_alert);

                //Soma da quantidade de ambientes nas query para apresentar na view
                $sum_rev_alerts = $alert_amb_venc->count() + $alert_amb_prox_venc->count();

                // Save last session to redirect [] links           
                $links = session()->get('links', []) ;
                $currentLink = request()->path();       // Getting current URI like 'ambiente/create/'
                array_unshift($links, $currentLink);    // Putting it in the beginning of links array
                session(['links' => $links]);           // Saving links array to the session

            View::share(['alerts' => $alerts, 'alert_amb_prox_venc'=> $alert_amb_prox_venc, 'prox_vencimento'=> $prox_vencimento, 'alert_amb_venc' => $alert_amb_venc, 'sum_rev_alerts' => $sum_rev_alerts, 'today' => $today, 'endtoday' => $endtoday, 'calendar_vt' => $calendar_vt, 'user' => $user, 'links' => $links, 'currentLink' => $currentLink]);

             }
        });
    
    }

}
