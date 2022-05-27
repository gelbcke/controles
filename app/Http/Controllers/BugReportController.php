<?php

namespace App\Http\Controllers;

use App\Models\BugReport;
use App\Models\User;
use Auth, Mail;
use Illuminate\Http\Request;

class BugReportController extends Controller
{
    protected   $request;

    public function __construct(Request $request)
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if(auth()->user()->can('Visualizar BugReport')){
            $bugs = BugReport::orderBy('created_at', 'desc')->get();
            return view ('bug_report.index', compact('bugs'));
        }
        else{
            return view('errors.401');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if(auth()->user()->can('Criar BugReport')){
            return view('bug_report.create');
        }
        else{
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
        $user_id = Auth::user()->id;
        $user_name = Auth::user()->name;
        $user_mail = Auth::user()->email;
        //
        if(auth()->user()->can('Criar BugReport')){
          $this->validate($request, [
            'modulo' => 'required',
            'descricao' => 'required'
        ]);


        $app_version = config('app.controles_app_version');
        //insert post data
        BugReport::create($request->all() + ['versao' => $app_version, 'user_id' => $user_id]);

/*
        //Envia e-mail para o usuário que reportou o problema
        $user_mail_data = array('name' => $user_name, 'problema' => $request->descricao, 'modulo' => $request->modulo);
        Mail::send('emails.bug_report_user', $user_mail_data, function($message)
        {
            $message->to(Auth::user()->email)
            ->subject('Controles - Obrigado!');
        });


        //Envia e-mail para o desenvolvedor do sistema
        $data = array('name' => 'Desenvolvedor', 'problema' => $request->descricao, 'modulo' => $request->modulo, 'usuario' => $user_name);
        Mail::send('emails.bug_report_dev', $data, function($message)
        {
            $message->to('dev@controles')
            ->subject('Novo Bug encontrado!');
        });

        // check for failures
        if (Mail::failures()) {
            toastr()->error('Não foi possível enviar o email para o Desenvolvedor!', 'ERRO', ['timeOut' => 5000]);
        }else{
            toastr()->success('E-mail enviado para o desenvolvedor!', 'OK', ['timeOut' => 5000]);
        }
*/
        toastr()->success('Bug registrado com sucesso!', 'Salvo', ['timeOut' => 5000]);
        return redirect()->route('bug_report.index');

        }
        else{
            return view('errors.401');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BugReport  $bugReport
     * @return \Illuminate\Http\Response
     */
    public function show(BugReport $bugReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BugReport  $bugReport
     * @return \Illuminate\Http\Response
     */
    public function edit(BugReport $bugReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BugReport  $bugReport
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        //
        if(auth()->user()->can('Editar BugReport')){
            $data = BugReport::find($id);
            $data->status = 1;
            $data->save();

            toastr()->success('Status do problema atualizado com sucesso!', 'OK', ['timeOut' => 5000]);
            return redirect()->route('bug_report.index');
        }else{
            return view('errors.401');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BugReport  $bugReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(BugReport $bugReport)
    {
        //
    }
}
