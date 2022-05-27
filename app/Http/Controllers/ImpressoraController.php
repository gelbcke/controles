<?php

namespace App\Http\Controllers;

use App\Models\Impressora;
use App\Models\Unidade;
use App\Models\Bloco;
use App\Models\Ambiente;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request as Input;
use DB, Auth, Toastr;

class ImpressoraController extends Controller
{
    protected   $request;

    public function __construct()
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
        if(auth()->user()->can('Visualizar Impressoras')){
            $user = Auth::user()->name;
            //Pega ID de Permissão para mostra dados do index

            $impressoras = Impressora::orderby('unidade_id', 'asc')
                ->orderby('bloco_id', 'asc')
                ->orderby('ambiente_id', 'asc')
                ->get();
            return view('impressora.index',compact('impressoras'));
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
    public function create(Request $request)
    {
        //
        if(auth()->user()->can('Criar Impressoras')){

            $unidades       = DB::table("unidades")->pluck("name","id");
            $blocos         = Bloco::all();
            $bloco          = Bloco::all()->pluck('bloco');
            $ambientes      = Ambiente::whereNull('status')->pluck('name');

            return view('impressora.create',compact('unidades','blocos','ambientes'));
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
        if(auth()->user()->can('Criar Impressoras')){
          $this->validate($request, [
            'unidade_id'        => 'required',
            'bloco_id'          => 'required',
            'ambiente_id'       => 'required',
            'modelo'            => 'required',
        ]);

        //insert post data
        Ambiente::where('id', $request->ambiente_id)->update(['hv_printer' => '1']);

        Impressora::create($request->all());

        toastr()->success('Impressora registrada com sucesso!', 'Salvo', ['timeOut' => 5000]);
        return redirect()->route('impressora.index');
        }
        else{
            return view('errors.401');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Impressora  $impressora
     * @return \Illuminate\Http\Response
     */
    public function show(Impressora $impressora)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Impressora  $impressora
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Impressora $impressora)
    {
        //
        if(auth()->user()->can('Editar Impressoras')){
            return view('impressora.edit',compact('impressora'));
        }
        else{
            return view('errors.401');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Impressora  $impressora
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        //
        if(auth()->user()->can('Editar Impressoras')){
            $impressora                         = Input::all();
            $impressoraUpdate                   = Impressora::find($id);
            $impressoraUpdate->modelo           = $impressora['modelo'];
            $impressoraUpdate->ip               = $impressora['ip'];
            $impressoraUpdate->ns               = $impressora['ns'];
            $impressoraUpdate->fila_impressao   = $impressora['fila_impressao'];
            $impressoraUpdate->contrato         = $impressora['contrato'];
            $impressoraUpdate->valor_locacao    = $impressora['valor_locacao'];
            $impressoraUpdate->save();

            toastr()->success('Impressora atualizada com sucesso!', 'Atualizado', ['timeOut' => 5000]);
            return redirect()->route('impressora.index');
        }
        else{
            return view('errors.401');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Impressora  $impressora
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Impressora $impressora, Request $request)
    {
        //
        if(auth()->user()->can('Remover Impressoras')){
            $find_amb = Impressora::where('id', $id)->value('ambiente_id');

            Ambiente::where('id', $find_amb)->update(['hv_printer' => '0']);
            Impressora::find($id)->delete();

            toastr()->success('Impressora removida com sucesso!', 'Removido', ['timeOut' => 5000]);
            return redirect()->route('impressora.index');
        }
        else{
            return view('errors.401');
        }
    }

    public function estatisticas()
    {
        //
        if(auth()->user()->can('Visualizar Impressoras')){
            $impressoras = Impressora::select(DB::raw('count(*) as qt_modelo, modelo'))
                             ->groupBy('modelo')
                             ->get();

            //Apresenta gráfico total de projetores por unidade
            $geral_unidades = Impressora::select(
                    DB::raw('unidades.id,unidades.name as unidade_count'),
                    'unidade_id as unidade' ,
                    DB::raw('COUNT(*) as impressoras_total')
                )
                ->join('unidades',function($q){
                        $q->on('impressoras.unidade_id', 'unidades.id');
                    })
                ->groupBy('unidade')
                ->get();


            return view ('impressora.estatisticas', compact('impressoras', 'geral_unidades'));
        }else{
            return view('errors.401');
        }
    }

    public function modelo_filter($modelo)
    {
        //
        $impressoras = Impressora::where('modelo', $modelo)->get();

        return view ('impressora.index', compact('impressoras'));
    }
}
