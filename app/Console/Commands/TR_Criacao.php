<?php

namespace App\Console\Commands;

use App\Models\TermosResponsabilidade;
use App\Mail\TRCriacaoMail;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Mail;

class TR_Criacao extends Command
{
    public $value;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tr_criacao:mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia email para o colaborador assim que o termo é criado com uma cópia digital anexada do mesmo.';

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
        $value = TermosResponsabilidade::whereNull('status')->latest('id')->first();

        //Envia email para devoluções vencidas
        Mail::to($value->email)->send(new TRCriacaoMail($value));

        //Salva o Log com Informações do envio
        $log_info = 'Email enviado para '.$value->colaborador. ' contendo em anexo, o termo de Responsabilidade do '.$value->equipamento.', patrimônio '.$value->pat.'.';
        activity('Info')->log($log_info);

        $this->info('Email com informações do termo enviada para o colaborador.');
    }
}
