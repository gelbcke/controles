<?php

namespace App\Http\Controllers;

use App\Models\Contrato;
use App\Models\Fornecedor;
use App\Models\Unidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as Input;
use Illuminate\Support\Facades\File;
use Hash, DB, Response, Storage;

class ContratoController extends Controller
{
    //private     $contrato;
    protected   $request;

    public function __construct(Request $request, Contrato $contrato)
    {
        $this->middleware('auth');
        //$this->contrato = $contrato;
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
         if(auth()->user()->can('Visualizar Contratos')){
           
            $contratos = Contrato::orderby('unidade_id', 'asc')
                ->orderby('supplier_id', 'asc')
                ->whereNull('status')
                ->orWhere('status', 0)
                ->get();
            return view('contratos.index',compact('contratos'));
        }
        else{
            return view('errors.401');
        }   
    }

    public function disabled()
    {
        //
        if(auth()->user()->can('Visualizar Contratos'))
        {

            $contratos = Contrato::orderby('unidade_id', 'asc')
                ->orderby('supplier_id', 'asc')
                ->where('status', 0)
                ->get();
            return view('contratos.index',compact('contratos'));
        }
        else
        {
            return view('errors.401');
        }   
    }

    public function download_file($path, $file)
    {
        $path = storage_path('doc').'/contracts/'.$path.'/'.$file;
        return Response::download($path);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
          if(auth()->user()->can('Criar Contratos')){
            $unidades       = Unidade::wherenull('status')->pluck('name', 'id');

            $query          = $request->get('term','');

            $contratos      = Fornecedor::whereNull('status')
                                ->orWhere('status', 1)
                                ->get();

                return view('contratos.create', compact('contratos', 'unidades'));
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
         if(auth()->user()->can('Criar Contratos')){

            $produto            = Input::get('product');
            $description        = Input::get('description');
           
            $destinationPath    = storage_path('/doc/contracts/'.$produto); 

            if ($request->hasFile('file')) {
                $contract           = $request->file('file');
                $extension          = $contract->getClientOriginalExtension();
                $contract->move($destinationPath, $produto.'_'.$description .'.'.$extension);
            }

            Contrato::create($request->all());

            toastr()->success('Contrato registrado com sucesso!', 'OK', ['timeOut' => 5000]);
            return redirect()->back();
        }else{
            return view('errors.401');
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Contrato  $contrato
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        //  
        if(auth()->user()->can('Visualizar Contratos')){

                $product        = Contrato::where('id', $id);
                $folder         = $product->value('product');
                $path           = storage_path('doc/contracts/').$folder;

                if(File::exists($path))
                {                        
                    $dir_path   = File::allFiles($path);
                }
                else{
                    $dir_path   = 0;
                }

                $contrato       = $product->get();

               
                return view('contratos.details',compact('dir_path', 'contrato')); 

            
        }else{
            return view('errors.401');
        }   
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contrato  $contrato
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Contrato $contrato)
    {
        //
        if(auth()->user()->can('Editar Contratos'))
        {
            $unidades   = Unidade::wherenull('status')->pluck('name', 'id');

            $query      = $request->get('term','');

            return view('contratos.edit',compact('contrato', 'unidades'));
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
     * @param  \App\Contrato  $contrato
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request, Contrato $contrato)
    {
        //
         if(auth()->user()->can('Editar Contratos')){
            $contratos                          = Input::all();
            $contratosUpdate                    = Contrato::find($id);
            $contratosUpdate->unidade_id        = $contratos['unidade_id'];
            //$contratosUpdate->supplier_id       = $contratos['supplier_id'];
            $contratosUpdate->product           = $contratos['product'];
            $contratosUpdate->description       = $contratos['description'];
            $contratosUpdate->start_date        = $contratos['start_date'];
            $contratosUpdate->end_date          = $contratos['end_date'];
            $contratosUpdate->month_cost        = $contratos['month_cost'];
            $contratosUpdate->total_cost        = $contratos['total_cost'];
            $contratosUpdate->obs               = $contratos['obs'];
                 

            $produto            = Input::get('product');
            $description        = Input::get('description');           
            $destinationPath    = storage_path('/doc/contracts/'.$produto); 


            if ($request->hasFile('file')) {
                $contract           = $request->file('file');                 
                $extension          = $contract->getClientOriginalExtension();
                $contract->move($destinationPath, $produto.'_'.$description .'.'.$extension);
                toastr()->info('Contrato do produto carregado com sucesso!', 'OK', ['timeOut' => 5000]);
            }
            
            $contratosUpdate->save(); 

            toastr()->success('Contrato atualizado com sucesso!', 'OK', ['timeOut' => 5000]);
            return redirect()->back();



        }
        else{
            return view('errors.401');
        }   
    }

    /**
     * Mark contrato as inactive
     *
     * @param  \App\Contrato  $contrato
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request, Contrato $contrato)
    {
        //
         if(auth()->user()->can('Remover Contratos')){
            $Contrato                = Contrato::find($id);
            $ContratoUpdate          = $Contrato;
            $ContratoUpdate->status  = 0;
            $ContratoUpdate->save();      

            toastr()->success('Contrato marcado como inativo!', 'OK', ['timeOut' => 5000]);
            return redirect()->route('contratos.index');
        }
        else
        {
            return view('errors.401');
        }  
    }

    /**
     * Mark contrato as active
     *
     * @param  \App\Contrato  $contrato
     * @return \Illuminate\Http\Response
     */
    public function active($id, Request $request, Contrato $contrato)
    {
        //
        if(auth()->user()->can('Remover Contratos')){
            $Contrato               = Contrato::find($id);
            $ContratoUpdate         = $Contrato;
            $ContratoUpdate->status = null;
            $ContratoUpdate->save();      

            toastr()->success('Contrato marcado como ativo!', 'OK', ['timeOut' => 5000]);
            return redirect()->route('contratos.index');
        }
        else
        {
            return view('errors.401');
        }   
    }
}