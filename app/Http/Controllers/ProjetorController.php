<?php

namespace App\Http\Controllers;

use App\Models\Projetor;
use App\Models\ProjetorModelo;
use App\Models\Unidade;
use App\Models\Bloco;
use App\Models\Ambiente;
use Illuminate\Http\Request;
use Laravel\Scout\Searchable;
use Illuminate\Support\Facades\Request as Input;
use DB;
use Illuminate\Support\Str;
use App\Traits\UploadTrait;

class ProjetorController extends Controller
{
    use UploadTrait;

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
        $unidades = Unidade::all()->pluck('name','id');

        return view ('projetor.index', compact('unidades'));
    }

    public function all()
    {
        //
        $projetores = Projetor::all();

        return view ('projetor.all', compact('projetores'));
    }

    public function modelo_filter($projetor_id)
    {
        //
        $projetores = Projetor::where('projetor_id', $projetor_id)->get();

        return view ('projetor.all', compact('projetores'));
    }


    public function infra_filter($id)
    {
        //
        $projetores = Projetor::where('infra', $id)->get();

        return view ('projetor.all', compact('projetores'));
    }

    public function suporte_filter($id)
    {
        //
        $projetores = Projetor::where('modelo_suporte', $id)->get();

        return view ('projetor.all', compact('projetores'));
    }

    public function model_datasheet($id)
    {
        //
        $projetores = ProjetorModelo::where('id', $id)->first();
        $proj_amb   = Projetor::where('projetor_id', $id)->get();

        return view ('projetor.model_datasheet', compact('projetores', 'proj_amb'));
    }

    public function estatisticas()
    {
        //
        if(auth()->user()->can('Visualizar Projetores')){
        //Count de Cabeamento
        $infra_hdmi             = Projetor::where('infra', "HDMI")->count();
        $infra_vga              = Projetor::where('infra', "VGA")->count();

        //Count de Suporte/Base
        $suporte_fixo           = Projetor::where('modelo_suporte', "Fixo")->count();
        $suporte_movel          = Projetor::where('modelo_suporte', "Móvel")->count();
        $suporte_interativo     = Projetor::where('modelo_suporte', "Interativo")->count();
        $suporte_universal      = Projetor::where('modelo_suporte', "Universal")->count();

        $projetores_f           = Projetor::select(DB::raw('count(*) as qt_modelo, projetor_id'))
                                 ->groupBy('projetor_id')
                                 ->get();

        //Apresenta gráfico total de projetores por modelo
        $geral_modelos = Projetor::select(
                DB::raw('projetor_modelos.id,CONCAT(projetor_modelos.fabricante , " - ", projetor_modelos.modelo) as projetor_count'),
                'projetor_id as projetor' ,
                DB::raw('COUNT(projetors.id) as projetor_total')
            )
            ->join('projetor_modelos',function($q){
                    $q->on('projetors.projetor_id', 'projetor_modelos.id');
                })
            ->groupBy('projetor')
            ->get();

        //Apresenta gráfico total de projetores por unidade
        $geral_unidades = Projetor::select(
                DB::raw('unidades.id,unidades.name as unidade_count'),
                'unidade_id as unidade' ,
                DB::raw('COUNT(*) as projetor_total')
            )
            ->join('unidades',function($q){
                    $q->on('projetors.unidade_id', 'unidades.id');
                })
            ->groupBy('unidade')
            ->get();

        return view ('projetor.estatisticas', compact('infra_hdmi', 'infra_vga', 'suporte_fixo', 'suporte_movel', 'suporte_interativo', 'suporte_universal', 'projetores_f', 'geral_modelos', 'geral_unidades'));
          }else{
            return view('errors.401');
        }
    }

    public function search(Request $request, Projetor $projetor)
    {
        //
        if(auth()->user()->can('Visualizar Projetores')){
            $unidade            = Input::get('unidade_id');
            $bloco              = Input::get('bloco_id');

            $query              = Projetor::where('unidade_id', $unidade)
                                ->when(Input::get('bloco_id') != 'empty_val', function ($query) use ($bloco) {
                                    $query->where('bloco_id', $bloco);
                                });

            $projetores         = $query->get();

            //Estatisticas do Ambiente
            $infra_hdmi         = (clone $query)->where('infra', 'HDMI')->count();
            $infra_vga          = (clone $query)->where('infra', 'VGA')->count();

            $suporte_fixo           = Projetor::where('modelo_suporte', "Fixo")->count();
            $suporte_movel          = Projetor::where('modelo_suporte', "Móvel")->count();
            $suporte_interativo     = Projetor::where('modelo_suporte', "Interativo")->count();
            $suporte_universal      = Projetor::where('modelo_suporte', "Universal")->count();

            $projetores_f       = (clone $query)->select(DB::raw('count(*) as qt_modelo, projetor_id'))
                                 ->groupBy('projetor_id')
                                 ->get();

            return view('projetor.search', compact('projetores', 'infra_vga', 'suporte_fixo', 'suporte_movel', 'suporte_interativo', 'suporte_universal', 'projetores_f'))->with('infra_hdmi', $infra_hdmi);

        }else{
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
        if(auth()->user()->can('Criar Projetores')){
            $unidades = Unidade::all()->pluck("name","id");
            $modelo   = ProjetorModelo::orderBy('fabricante')->get();

            return view('projetor.create',compact('unidades','modelo'));
        }else{
            return view('errors.401');
        }
    }

    public function create_model(Request $request)
    {
        //
        if(auth()->user()->can('Criar Projetores')){
            return view('projetor.create_model');
        }else{
            return view('errors.401');
        }
    }

    public function store_model(Request $request)
    {
        //
        if(auth()->user()->can('Criar Projetores')){

            $ProjImage                      = new ProjetorModelo;
            $ProjImage->fabricante          = Input::get('fabricante');
            $ProjImage->modelo              = Input::get('modelo');
            $ProjImage->pixels              = Input::get('pixels');
            $ProjImage->lumens              = Input::get('lumens');
            $ProjImage->max_resolution      = Input::get('max_resolution');
            $ProjImage->lamp_max_time       = Input::get('lamp_max_time');
            $ProjImage->distance_projection = Input::get('distance_projection');
            $ProjImage->max_screen_size     = Input::get('max_screen_size');
            $ProjImage->contrast            = Input::get('contrast');
            $ProjImage->color_reproduction  = Input::get('color_reproduction');
            $ProjImage->sound               = Input::get('sound');
            $ProjImage->projection_mode     = Input::get('projection_mode');
            $ProjImage->energy_consumption  = Input::get('energy_consumption');
            $ProjImage->weight              = Input::get('weight');
            $ProjImage->wireless            = Input::get('wireless');

            $image                          = $request->file('projector_image');
            $extension                      = $image->getClientOriginalExtension();

            if ($request->hasFile('projector_image')) {
                $ProjImage->projector_image = $ProjImage->fabricante."_".$ProjImage->modelo.".".$extension;
                $destinationPath            = public_path('/images/projetores');
                $image->move($destinationPath, $ProjImage->fabricante."_".$ProjImage->modelo.".".$extension);
            }else{
                $ProjImage->projector_image;
            }

            $ProjImage->save();

            toastr()->success('Modelo de projetor registrado com sucesso!', 'OK', ['timeOut' => 5000]);
        return redirect()->route('projetor.create_model');
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
        if(auth()->user()->can('Criar Projetores')){
          $this->validate($request, [
            'unidade_id'        => 'required',
            'bloco_id'          => 'required',
            'ambiente_id'       => 'required',
            'projetor_id'       => 'required',
            'infra'             => 'required'
        ]);

        //insert post data
        Ambiente::where('id', $request->ambiente_id)->update(['hv_proj' => '1']);
        Projetor::create($request->all());

        toastr()->success('Projetor registrado com sucesso!', 'OK', ['timeOut' => 10000]);
        return redirect()->route('projetor.all');
        }
        else{
            return view('errors.401');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Projetor  $projetor
     * @return \Illuminate\Http\Response
     */
    public function show(Projetor $projetor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Projetor  $projetor
     * @return \Illuminate\Http\Response
     */
    public function edit(Projetor $projetor)
    {
        //
        if(auth()->user()->can('Editar Projetores')){
            $unidades     = Unidade::all()->pluck("name","id");
            $modelo       = ProjetorModelo::orderBy('fabricante')->get();
            $projetor_id  = ProjetorModelo::get();

            return view('projetor.edit',compact('unidades', 'modelo', 'projetor_id','projetor'));
        }
        else{
            return view('errors.401');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Projetor  $projetor
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request, Projetor $projetor)
    {
        //
        if(auth()->user()->can('Editar Projetores')){
            // Atualiza os valores no DB
            $projetor       = Input::all();
            $projetorUpdate = Projetor::findOrFail($id);

            if($request->ambiente_id != $projetor['ambiente_id']){
                Ambiente::where('id', $request->ambiente_id)->update(['hv_proj' => '1']);
                Ambiente::where('id', $projetor['ambiente_id'])->update(['hv_proj' => '0']);
            }

            $projetorUpdate->unidade_id     = $projetor['unidade_id'];
            $projetorUpdate->bloco_id       = $projetor['bloco_id'];
            $projetorUpdate->ambiente_id    = $projetor['ambiente_id'];
            $projetorUpdate->projetor_id    = $projetor['projetor_id'];
            $projetorUpdate->patrimonio     = $projetor['patrimonio'];
            $projetorUpdate->ns             = $projetor['ns'];
            $projetorUpdate->infra          = $projetor['infra'];
            $projetorUpdate->modelo_suporte = $projetor['modelo_suporte'];

            $projetorUpdate->save();

            toastr()->success('Projetor atualizado com sucesso!', 'OK', ['timeOut' => 5000]);
            return redirect()->route('projetor.all');
        }
        else{
            return view('errors.401');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Projetor  $projetor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Projetor $projetor, Request $request)
    {
        //
                //
        if(auth()->user()->can('Remover Projetores')){
            $find_amb = Projetor::where('id', $id)->value('ambiente_id');

            Ambiente::where('id', $find_amb)->update(['hv_proj' => '0']);
            Projetor::find($id)->delete();

            toastr()->success('Projetor removido com sucesso!', 'Removido', ['timeOut' => 5000]);
            return redirect()->route('projetor.all');
        }
        else{
            return view('errors.401');
        }
    }
}
