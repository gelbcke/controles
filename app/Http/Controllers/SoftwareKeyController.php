<?php

namespace App\Http\Controllers;

use App\Models\SoftwareKey;
use App\Models\SoftwareList;
use App\Models\Fornecedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as Input;
use Illuminate\Support\Facades\File;
use Hash, DB, Response, Storage;

class SoftwareKeyController extends Controller
{
    private     $softwareKey;
    protected   $request;

    public function __construct(Request $request, SoftwareKey $softwareKey)
    {
        $this->middleware('auth');
        $this->softwareKey = $softwareKey;
    }

    public function disabled_details($id, Request $request, SoftwareKey $softwareKey)
    {
          //
        if(auth()->user()->can('Visualizar Licença')){

                $version = Input::get('softwareVersion');
                $software_id = Input::get('softwareKey');

                $software = SoftwareKey::where('software_id', $id)
                    ->whereNotNull('status');

                $software_name  = SoftwareList::where('id', $software->value('software_id'));
                $folder         = $software_name->value('name');
                $path           = storage_path('doc/software_key/').$folder;

                if(File::exists($path))
                {
                    $dir_path   = File::allFiles($path);
                }
                else{
                    $dir_path   = 0;
                }

                $software_keys  = $software->get();

                $has_key_dis    = SoftwareKey::whereNotNull('status')->get();

                return view('software_key.details',compact('software_keys', 'dir_path', 'has_key_dis'));

            /*else{
                toastr()->error('Senha Inválida!', 'OPSS!', ['timeOut' => 5000]);
                return redirect()->back();
            }*/
        }else{
            return view('errors.401');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function details(Request $request, SoftwareKey $softwareKey)
    {
        //
        if(auth()->user()->can('Visualizar Licença')){

            if (Hash::check(request('password'), auth()->user()->password)){

                $version = Input::get('softwareVersion');
                $software_id = Input::get('softwareKey');

                if($version){
                    $software = SoftwareKey::where('software_id', $software_id)->where('version', $version)
                    ->whereNull('status');
                }else{

                $software = SoftwareKey::where('software_id', $software_id)
                    ->whereNull('status');

                }

                $software_name  = SoftwareList::where('id', $software->value('software_id'));
                $folder         = $software_name->value('name');
                $path           = storage_path('doc/software_key/').$folder;

                if(File::exists($path))
                {
                    $dir_path   = File::allFiles($path);
                }
                else{
                    $dir_path   = 0;
                }

                $software_keys  = $software->get();

                $has_key_dis    = SoftwareKey::where('software_id', $software_id)->whereNotNull('status')->get();

                return view('software_key.details',compact('software_keys', 'dir_path', 'has_key_dis'));

            }/*else{
                toastr()->error('Senha Inválida!', 'OPSS!', ['timeOut' => 5000]);
                return redirect()->back();
            }*/
        }else{
            return view('errors.401');
        }
    }

    /**
    *
    * Download files of app
    *
    */
    public function download_file($path, $file)
    {
        $path = storage_path('doc').'/software_key/'.$path.'/'.$file;
        return Response::download($path);
    }

    /**
    *
    * Make a Search of Software
    *
    */
    public function searchSoftware(Request $request)
    {
        if(auth()->user()->can('Visualizar Licença')){
            $data = [];

            if($request->has('q')){
                $search = $request->q;
                $data = DB::table("software_lists")
                        ->select("id","name")
                        ->where('name','LIKE',"%$search%")
                        ->get();
            }
            return response()->json($data);
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
        if(auth()->user()->can('Criar Licença')){
            $query          = $request->get('term','');
            $software_list  = SoftwareList::where('name','LIKE','%'.$query.'%')
                                ->orderBy('name', 'asc')
                                ->get();

            $fornecedor     = Fornecedor::whereNull('status')
                                ->orWhere('status', 1)
                                ->get();

                return view('software_key.create', compact('software_list', 'fornecedor'));
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
        //
        if(auth()->user()->can('Criar Licença')){

            $sft_name = SoftwareList::where('id', Input::get('software_id'))->value('name');

            $destinationPath    = storage_path('/doc/software_key/'.$sft_name);

			if ($request->hasFile('nfe_file')) {
				$nfe                = $request->file('nfe_file');
				$extension          = $nfe->getClientOriginalExtension();
				$nfe->move($destinationPath, 'NFE - '. $sft_name .'_v'. Input::get('version') .'.'.$extension);
			}

			if ($request->hasFile('contract_file')) {
				$contrato           = $request->file('contract_file');
				$extension          = $contrato->getClientOriginalExtension();
				$contrato->move($destinationPath, 'Contrato - '. $sft_name .'_v'. Input::get('version') .'.'.$extension);
			}

            SoftwareKey::create($request->all());

            toastr()->success('Licença de software registrado com sucesso!', 'OK', ['timeOut' => 5000]);
            return redirect()->back();
        }else{
            return view('errors.401');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SoftwareKey  $softwareKey
     * @return \Illuminate\Http\Response
     */
    public function show(SoftwareKey $softwareKey)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SoftwareKey  $softwareKey
     * @return \Illuminate\Http\Response
     */
    public function edit(SoftwareKey $softwareKey)
    {
        //
        if(auth()->user()->can('Editar Licença')){
            $fornecedor     = Fornecedor::whereNull('status')
                                ->orWhere('status', 1)
                                ->get();

            return view('software_key.edit',compact('softwareKey', 'fornecedor'));
        }
        else
        {
            return view('errors.401');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SoftwareKey  $softwareKey
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {

        if(auth()->user()->can('Editar Licença')){
        // Atualiza os valores no DB
            $softwareKey                            = Input::all();
            $softwareKeyUpdate                      = SoftwareKey::find($id);
            $softwareKeyUpdate->key                 = $softwareKey['key'];
            $softwareKeyUpdate->server              = $softwareKey['server'];
            $softwareKeyUpdate->server_port         = $softwareKey['server_port'];
            $softwareKeyUpdate->account             = $softwareKey['account'];
            $softwareKeyUpdate->account_password    = $softwareKey['account_password'];
            $softwareKeyUpdate->obs                 = $softwareKey['obs'];
            $softwareKeyUpdate->date_last_order     = $softwareKey['date_last_order'];
            $softwareKeyUpdate->supplier_id         = $softwareKey['supplier_id'];
            $softwareKeyUpdate->due_date            = $softwareKey['due_date'];
            $softwareKeyUpdate->qt_license          = $softwareKey['qt_license'];
            $softwareKeyUpdate->nfe                 = $softwareKey['nfe'];
            $softwareKeyUpdate->oc                  = $softwareKey['oc'];
            $softwareKeyUpdate->renovation_period   = $softwareKey['renovation_period'];
            $softwareKeyUpdate->install_soft_local  = $softwareKey['install_soft_local'];
            $softwareKeyUpdate->install_lic_local   = $softwareKey['install_lic_local'];
            $softwareKeyUpdate->description         = $softwareKey['description'];


            $sft_name = SoftwareList::where('id', $softwareKeyUpdate->software_id)->value('name');
            $destinationPath    = storage_path('/doc/software_key/'.$sft_name);

            if ($request->hasFile('nfe_file')) {
                $nfe                = $request->file('nfe_file');
                $extension          = $nfe->getClientOriginalExtension();
                $nfe->move($destinationPath, 'NFE - '.$sft_name .'_v'. $softwareKeyUpdate->version .'.'.$extension);
                toastr()->info('NFE do software carregado com sucesso!', 'OK', ['timeOut' => 5000]);
            }

            if ($request->hasFile('contract_file')) {
                $contrato           = $request->file('contract_file');
                $extension          = $contrato->getClientOriginalExtension();
                $contrato->move($destinationPath, 'Contrato - '.$sft_name .'_v'.  $softwareKeyUpdate->version .'.'.$extension);
                toastr()->info('Contrato do Software carregado com sucesso!', 'OK', ['timeOut' => 5000]);
            }

            $softwareKeyUpdate->save();

            toastr()->success('Chave do software atualizado com sucesso!', 'OK', ['timeOut' => 5000]);
            return redirect()->back();
        }
        else
        {
            return view('errors.401');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SoftwareKey  $softwareKey
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request, SoftwareKey $softwareKey)
    {
        //
        if(auth()->user()->can('Remover Licença')){
            $softwareKey                = SoftwareKey::find($id);
            $softwareKeyUpdate          = $softwareKey;
            $softwareKeyUpdate->status  = 0;
            $softwareKeyUpdate->save();

            toastr()->success('Chave do software desabilitado com sucesso!', 'OK', ['timeOut' => 5000]);
            return redirect()->route('softwarelist.index');
        }
        else
        {
            return view('errors.401');
        }
    }
}
