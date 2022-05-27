<?php

namespace App\Http\Controllers;

use App\Models\RelogioPonto;
use App\Models\Unidade;
use App\Models\Bloco;
use App\Models\Ambiente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as Input;
use DB;
use Toastr;
use Auth;

class RelogioPontoController extends Controller
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
        if(auth()->user()->can('Visualizar Relógios Ponto')){
            $relogios_ponto = RelogioPonto::get();
            return view('relogio_ponto.index', compact('relogios_ponto'));
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
        if(auth()->user()->can('Criar Relógios Ponto')){
            $unidades       = Unidade::pluck("name","id");
            $blocos         = Bloco::all();
            $bloco          = Bloco::all()->pluck('bloco');
            $ambientes      = Ambiente::whereNull('status')->pluck('name');
            return view('relogio_ponto.create',compact('unidades','blocos','ambientes'));
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
        //
         //
        if(auth()->user()->can('Criar Relógios Ponto')){
          $this->validate($request, [
                'unidade_id'        => 'required',
                'bloco_id'          => 'required'
            ]);
          
            //insert post data
            RelogioPonto::create($request->all());

            toastr()->success('Relógio Ponto registrado com sucesso!', 'Salvo', ['timeOut' => 5000]);
            return redirect()->route('relogio_ponto.index');
        }
        else{
            return view('errors.401');
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Relogio_Ponto  $relogio_Ponto
     * @return \Illuminate\Http\Response
     */
    public function show(RelogioPonto $relogioPonto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Relogio_Ponto  $relogio_Ponto
     * @return \Illuminate\Http\Response
     */
    public function edit(RelogioPonto $relogioPonto)
    {
        //
        if(auth()->user()->can('Editar Relógios Ponto')){
            return view('relogio_ponto.edit',compact('relogioPonto'));
        }
        else{
            return view('errors.401');
        }   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Relogio_Ponto  $relogio_Ponto
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request, RelogioPonto $relogioPonto)
    {
        //
         if(auth()->user()->can('Editar Relógios Ponto')){
            $relogioPonto                         = Input::all();
            $relogioPontoUpdate                   = RelogioPonto::find($id);
            $relogioPontoUpdate->fabricante       = $relogioPonto['fabricante'];
            $relogioPontoUpdate->modelo           = $relogioPonto['modelo'];
            $relogioPontoUpdate->pat              = $relogioPonto['pat'];
            $relogioPontoUpdate->ns               = $relogioPonto['ns'];
            $relogioPontoUpdate->obs              = $relogioPonto['obs'];
            $relogioPontoUpdate->save(); 

            toastr()->success('Relógio Ponto atualizado com sucesso!', 'Atualizado', ['timeOut' => 5000]);
            return redirect()->route('relogio_ponto.index');
        }
        else{
            return view('errors.401');
        }   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Relogio_Ponto  $relogio_Ponto
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, RelogioPonto $relogioPonto)
    {
        //
        if(auth()->user()->can('Remover Relógios Ponto')){
                RelogioPonto::find($id)->delete();
                toastr()->success('Relógio Ponto removido com sucesso!', 'Removido', ['timeOut' => 5000]);
            return redirect()->route('relogio_ponto.index');
        }
        else{
            return view('errors.401');
        }  
    }
}
