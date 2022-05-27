<?php

namespace App\Http\Controllers;

use App\Models\Imagem;
use App\Models\Unidade;
use App\Models\Bloco;
use App\Models\Ambiente;
use App\Models\User;
use App\Models\Software;
use App\Models\SoftwareList;
use App\Models\RevisaoAmbienteAtividade;
use Illuminate\Http\Request;
use Auth, Toastr, DB;
use Carbon\Carbon;

class ImagemController extends Controller
{

    protected $request;

    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->request = $request;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if(auth()->user()->can('Visualizar Imagens')){
           
            $image_list     = Imagem::select(DB::raw('max(version) as version'),
                                    DB::raw('max(id) as id'),
                                    'imagems.unidade_id as unidade_id',
                                    'imagems.bloco_id as bloco_id',
                                    'imagems.image_name as image_name'
                                     )
                                ->orderBy('version', 'desc')
                                ->groupBy(['unidade_id', 'bloco_id', 'image_name'])
                                ->get();
            //dd($image_list);
                
            $imagem         = Imagem::pluck('image_name','id');

            return view('imagem.index',compact('image_list','imagem'));
        }else{
            return view('errors.401');
        } 
    }

    public function all()
    {
        //
        if(auth()->user()->can('Visualizar Imagens')){
           
            $image_list = Imagem::orderByRaw('unidade_id desc', 'bloco_id desc', 'image_name desc', 'version desc')
                ->get();
            //dd($image_list);
                
            $imagem = Imagem::pluck('image_name','id');

            return view('imagem.index',compact('image_list','imagem'));
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
        if(auth()->user()->can('Criar Imagens')){
            $unidades = Unidade::all()
                ->pluck('name','id');

            $blocos = Bloco::all();

            $bloco = Bloco::all()
                ->pluck('bloco');

            $ambientes = Ambiente::all()->where('status', '!=', null)
                ->pluck('ambiente','id');

            $users = User::orderBy('name', 'asc')
                ->get();

            return view('imagem.create',compact('unidades','blocos','ambientes','users'));
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
        if(auth()->user()->can('Criar Imagens')){
            $this->validate($request, [
                'unidade_id' => 'required',
                'bloco_id' => 'required'
            ]);
            Imagem::create($request->all());

            toastr()->success('Imagem registrada com sucesso!', 'OK', ['timeOut' => 5000]);
            return redirect()->route('imagem.index');
        }else{
            return view('errors.401');
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Imagem  $imagem
     * @return \Illuminate\Http\Response
     */
    public function show(Imagem $imagem)
    {
        //
        if(auth()->user()->can('Visualizar Imagens')){
            $tomorrow       = Carbon::tomorrow()->startOfDay();
            $aftertomorrow  = Carbon::tomorrow()->endOfDay();
            $softwares      = Software::where('imagem_id', $imagem->id)->get();
            return view('imagem.show',compact('imagem','softwares', 'tomorrow', 'aftertomorrow'));
        }else{
            return view('errors.401');
        } 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Imagem  $imagem
     * @return \Illuminate\Http\Response
     */
    public function edit(Imagem $imagem)
    {
        //
        if(auth()->user()->can('Editar Imagens')){
            ///
        }else{
            return view('errors.401');
        } 
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update_version($id, Request $request)
    {
        //
        if(auth()->user()->can('Criar Imagens')){

            $users      = User::orderBy('name', 'asc')->get(); 
            $imagem     = Imagem::where('id', $id)->first();
            $software   = Software::where('imagem_id', $id)->get();

            return view('imagem.update',compact('software','imagem', 'users'));
        }else{
            return view('errors.401');
        } 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Imagem  $imagem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Imagem $imagem)
    {
        //
        if(auth()->user()->can('Editar Imagens')){
            ///
        }else{
            return view('errors.401');
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Imagem  $imagem
     * @return \Illuminate\Http\Response
     */
    public function destroy(Imagem $imagem)
    {
        //
        if(auth()->user()->can('Remover Imagens')){
            ///
        }else{
            return view('errors.401');
        }  
    }

    public function soft_amb($id, Request $request, Imagem $imagem)
    {
        //
        $today          = Carbon::today()->startOfDay();
        $tomorrow       = Carbon::tomorrow()->startOfDay();
        $aftertomorrow  = Carbon::tomorrow()->endOfDay();
        $unidades       = Unidade::all()->pluck('name', 'id');
            
        $atv_n1         = RevisaoAmbienteAtividade::where('nivel', 'Nível 1')->value('atividades');  
        $atv_n2         = RevisaoAmbienteAtividade::where('nivel', 'Nível 2')->value('atividades'); 
        $atv_n3         = RevisaoAmbienteAtividade::where('nivel', 'Nível 3')->value('atividades');

        $ambientes      = Ambiente::whereNull('status')->where('imagem_id', $id)->get();

        return view('ambiente.index',compact('ambientes', 'unidades', 'atv_n1', 'atv_n2', 'atv_n3', 'today', 'tomorrow', 'aftertomorrow'));
    }
}
