<?php

namespace App\Http\Controllers;

use App\Models\Software;
use App\Models\OuMachines;
use App\Models\Unidade;
use App\Models\Bloco;
use App\Models\Ambiente;
use App\Models\SoftwareList;
use App\Models\Imagem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as Input;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use DB, Toastr;

class SoftwareController extends Controller
{
    private     $software;
    protected   $request;

    public function __construct(Request $request, Software $software)
    {
        $this->middleware('auth');
        $this->software = $software;
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request, Ambiente $ambiente)
    {
        //
        if(auth()->user()->can('Visualizar Softwares')){
            $unidade = Input::get('unidade_id');
            $bloco = Input::get('bloco_id');
            $ambiente = Input::get('ambiente');

            $filter = Ambiente::whereNull('status')
            ->where('unidade_id',$unidade)
            ->where('bloco_id', $bloco)
            ->where('id', $ambiente)
            ->pluck('imagem_id');

            $searchs = Imagem::where('id', $filter)->get();

            $softwares = Software::where('imagem_id',$filter)
            ->get();

            $ambiente_nome = Ambiente::whereNull('status')->where('id', $ambiente)->value('name');

            return view('software.search', compact('softwares', 'ambiente', 'searchs','ambiente_nome'));
        }else{
            return view('errors.401');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->can('Visualizar Softwares')){
            $unidades = DB::table("unidades")->pluck("name","id");
            return view('software.index',compact('unidades'));
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
        if(auth()->user()->can('Criar Softwares')){
            // Passa a Lista de Softwares registrados para a controller SoftwareList
            $software_list = SoftwareList::orderBy('name')->get();

            $unidades = DB::table("unidades")->pluck("name","id");

            $imagens =  Imagem::select(DB::raw('max(version) as version'),
                            DB::raw('max(id) as id'),
                            'imagems.unidade_id as unidade_id',
                            'imagems.bloco_id as bloco_id',
                            'imagems.image_name as image_name')
                        //->orderByRaw('unidade_id desc', 'bloco_id desc')
                        ->groupBy(['id','version','unidade_id', 'bloco_id', 'image_name'])
                        ->get();



            return view('software.create',compact('software_list','unidades','imagens'));
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
        if(auth()->user()->can('Criar Softwares')){
            //validate post data
            $software = Software::get(['imagem_id', 'software_list_id', 'app_version']);

            for ($i = 0; $i < count($request->name); $i++)
            {
             $this->software->create([
                'software_list_id'      => SoftwareList::where('name', $request->name[$i])->value('id'),
                'app_version'           => $request->version[$i] ,
                'imagem_id'             => $request->imagem_id,
            ]);
         }

             toastr()->success('Software registrado com sucesso!', 'OK', ['timeOut' => 5000]);
             return redirect()->route('imagem.index');
         }else{
            return view('errors.401');
        }
    }

    /**
     * Atualiza Versão da Imagem com nova lista de softwares
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update_img(Imagem $imagem, Request $request)
    {
        if(auth()->user()->can('Criar Softwares')){

            $unidade_id = Imagem::where('id', $request->imagem_id)->value('unidade_id');
            $bloco_id   = Imagem::where('id', $request->imagem_id)->value('bloco_id');
            $image_name = Imagem::where('id', $request->imagem_id)->value('image_name');

            $date_of_creation   = $request->date_of_creation;
            $creator            = $request->creator;
            $reviewer           = $request->reviewer;
            $file_name          = $request->file_name;
            $img_new_version    = $request->img_new_version;

            //Imagem::create(['unidade_id' => $unidade_id, 'bloco_id' => $bloco_id, 'image_name' => $image_name]);

            $this->validate($request, [
                'date_of_creation'      => 'required',
                'creator'               => 'required',
                'file_name'             => 'required',
                'img_new_version'       => 'required',

            ]);

            Imagem::create([
                'unidade_id'            => $unidade_id,
                'bloco_id'              => $bloco_id,
                'image_name'            => $image_name,
                'date_of_creation'      => $date_of_creation,
                'creator'               => $creator,
                'reviewer'              => $reviewer,
                'file_name'             => $file_name,
                'version'               => $img_new_version,
            ]);

            //validate post data
            $new_img        = Imagem::latest()->first();
            $software       = Software::get(['imagem_id', 'software_list_id', 'app_version']);

            for ($i = 0; $i < count($request->name); $i++)
            {
             $this->software->create([
                'software_list_id'      => SoftwareList::where('name', $request->name[$i])->value('id'),
                'app_version'           => $request->version[$i] ,
                'imagem_id'             => $new_img->id,
            ]);
            }
            toastr()->success('Atualização da imagem realizada com sucesso!', 'OK', ['timeOut' => 5000]);
            return redirect()->route('imagem.index');

         }else{
            return view('errors.401');
        }
    }

    /**
    * Display the specified resource.
    *
    * @param  \App\Software  $software
    * @return \Illuminate\Http\Response
    */
    public function show(Software $software)
    {
        if(auth()->user()->can('Visualizar Softwares'))
        {
            return view('software.show',compact('software','software_lists'));
        }
        else{
            return view('errors.401');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Software  $software
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Software $software)
    {
        //
        if(auth()->user()->can('Editar Softwares')){
            return view('software.edit',compact('software'));
        }else{
            return view('errors.401');
        }
    }

     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Software  $software
     * @return \Illuminate\Http\Response
     */
     public function update($id, Request $request, Software $software)
     {
        if(auth()->user()->can('Editar Softwares')){
            // Atualiza somente o input version
            $software = Input::all();
            $softwareUpdate = Software::find($id);
            $softwareUpdate->version = $software['version'];
            $softwareUpdate->save();

            Alert::success('Atualizado', 'Software atualizado com sucesso!');
            return redirect()->back();
        }else{
            return view('errors.401');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Software  $software
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request, Software $software)
    {
        //
        if(auth()->user()->can('Remover Softwares')){
            Software::find($id)->delete();
            Alert::success('Removido', 'Software Removido com sucesso!');
            return redirect()->back();
        }else{
            return view('errors.401');
        }
    }

    public function getBlocoList(Request $request)
    {
        $blocos = DB::table("blocos")
        ->where("unidade_id",$request->unidade_id)
        ->pluck("name","id");
        return response()->json($blocos);
    }

    public function getAmbienteList(Request $request)
    {
        $ambientes = DB::table("ambientes")
        ->where('status', null)
        ->where("bloco_id",$request->bloco_id)
        ->orderBy("ambiente", "asc")
        ->pluck("ambiente","id");
        return response()->json($ambientes);
    }

    public function addMore()
    {
        return view("addMore");
    }

    public function addMorePost(Request $request)
    {
        $rules = [];
        foreach($request->input('software_id') as $key => $value) {
            $rules["software_id.{$key}"] = 'required';
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            foreach($request->input('software_id') as $key => $value) {
                TagList::create(['software_id'=>$value]);
            }
            return response()->json(['success'=>'done']);
        }
        return response()->json(['error'=>$validator->errors()->all()]);
    }

}
