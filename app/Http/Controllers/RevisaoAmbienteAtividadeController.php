<?php

namespace App\Http\Controllers;

use App\Models\RevisaoAmbienteAtividade;
use Illuminate\Http\Request;
use Toastr, Session;
use Illuminate\Support\Facades\Request as Input;
use Illuminate\Support\Facades\Redirect;

class RevisaoAmbienteAtividadeController extends Controller
{
    private     $revisaoambienteatividades;
    protected   $request;

    public function __construct(RevisaoAmbienteAtividade $revisaoambienteatividades)
    {
        $this->middleware('auth');
        $this->revisaoambienteatividades = $revisaoambienteatividades;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(RevisaoAmbienteAtividade $revisaoAmbienteAtividades, Request $request)
    {
        //
        if(auth()->user()->can('Visualizar Lista de Atividades')){

            $niveis = RevisaoAmbienteAtividade::orderby('id', 'asc')->get();           

            return view('revisao_atividades.index',compact('niveis'));
        }else{
            return view('errors.401');
        } 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        if(auth()->user()->can('Criar Lista de Atividades')){
            return view('revisao_atividades.create');
        }else{
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
        //validate post data
        if(auth()->user()->can('Criar Lista de Atividades')){
            $this->validate($request, [
            'atividades'            => 'required',
            'nivel'                 => 'required'
           
            ]);
      
            $revisaoambienteatividades = RevisaoAmbienteAtividade::get(['atividades']);
            for ($i = 0; $i < count($request->atividades); $i++) 
            { 
                $this->revisaoambienteatividades->create([
                    'atividades'    => $request->atividades[$i],
                    'nivel'         => $request->nivel
                ]);
            } 
            
            toastr()->success('Atividade registrada com sucesso!', 'OK', ['timeOut' => 5000]);
            return redirect()->route('revisao_atividades.index');
        }else{
            return view('errors.401');
        } 
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RevisaoAmbienteAtividade  $revisaoAmbienteAtividades
     * @return \Illuminate\Http\Response
     */
    public function show(RevisaoAmbienteAtividade $revisaoAmbienteAtividades, Request $request)
    {
        //
        $atividades = RevisaoAmbienteAtividade::where('nivel', $request->niveis)->get();
        return view('revisao_atividades.show', compact('revisaoAmbienteAtividades', 'atividades'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RevisaoAmbienteAtividade  $revisaoAmbienteAtividades
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        if(auth()->user()->can('Editar Lista de Atividades')){
            $revisao = RevisaoAmbienteAtividade::findOrFail($id);
            return view('revisao_atividades.edit',compact('revisao')); 
        }else{
            return view('errors.401');
        } 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RevisaoAmbienteAtividade  $revisaoAmbienteAtividades
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        if(auth()->user()->can('Editar Lista de Atividades')){

            $atividades                     = Input::all();
            $atividadesUpdate               = RevisaoAmbienteAtividade::find($id);
            $atividadesUpdate->atividades   = $atividades['atividades'];
            $atividadesUpdate->save(); 

            toastr()->success('Atividade alterada com sucesso!', 'OK', ['timeOut' => 5000]);
            return redirect()->route('revisao_atividades.index');
        }else{
            return view('errors.401');
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RevisaoAmbienteAtividade  $revisaoAmbienteAtividades
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, RevisaoAmbienteAtividade $revisaoAmbienteAtividades)
    {
        //
        $atividade = RevisaoAmbienteAtividade::find($id);
        $atividade->delete();

        // redirect
        toastr()->success('Atividade removida com sucesso!', 'OK', ['timeOut' => 5000]);
         return redirect()->back();
    }
}
