<?php

namespace App\Mail;

use App\Models\TermosResponsabilidade;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class TRDevolucaoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $value;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($value)
    {
        //
        $this->value = $value;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
         //Envia email ao colaborador que deverá devolver o equipamento do empréstimo
        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                    //->attach(storage_path('app/logo/logo_up.png'))
                    ->subject('Devolução de Equipamento.')
                    ->view('emails.termos.tr_devolucao');
    }
}
