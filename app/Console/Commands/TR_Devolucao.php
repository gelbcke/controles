<?php

namespace App\Console\Commands;

use App\Models\TermosResponsabilidade;
use App\Mail\TRDevolucaoMail;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Mail;

class TR_Devolucao extends Command
{
    public $value;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tr_devolucao:mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia email para os colaboradores que deverão devolver os equipamentos que foram emprestados provisóriamente';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(TermosResponsabilidade $value)
    {
        $this->value = $value;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $today = Carbon::today()->startOfDay();
        $termosResponsabilidade = TermosResponsabilidade::where('dt_entrega', '<=', $today)->whereNull('status')->get();

        foreach($termosResponsabilidade as $value){
            //Envia email para devoluções vencidas
            Mail::to($value->email)->send(new TRDevolucaoMail($value));

            //Salva o Log com Informações do envio
            $log_info = 'Email enviado para '.$value->colaborador. ' solicitando a devolução do '.$value->equipamento.', patrimônio '.$value->pat.', com data de devolução agendada para o dia '.date('d/m/Y', strtotime($value->dt_entrega)).'.';
            activity('Info')->log($log_info);
            }

        $this->info('Email de Alerta enviado para todos os colaboradores.');
        
    }
}
