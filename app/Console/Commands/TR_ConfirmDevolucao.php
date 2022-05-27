<?php

namespace App\Console\Commands;

use App\Models\TermosResponsabilidade;
use App\Mail\TRConfirmDevolucaoMail;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Mail;

class TR_ConfirmDevolucao extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tr_confirmdevolucao:mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia email para o colaborador confirmando a devolução do equipamento.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
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
    }
}
