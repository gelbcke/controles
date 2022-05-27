<?php

namespace App\Mail;

use App\Models\TermosResponsabilidade;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class TRCriacaoMail extends Mailable
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
        $termo = termosResponsabilidade::latest('id')->first();
         //Envia email ao colaborador que deverá devolver o equipamento do empréstimo
        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                    ->attach(public_path('doc/temp/TR_'. $termo->id . '.docx'))
                    ->subject('Termo de Responsabilidade '.$termo->id.'.')
                    ->view('emails.termos.tr_criacao');
    }
}
