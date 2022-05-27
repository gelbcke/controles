<?php

namespace App\Http\Controllers;

use App\Models\Fornecedor;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Request as Input;

class FornecedorController extends Controller
{
    private $fornecedor;
    protected $request;

    public function __construct(Request $request, Fornecedor $fornecedor)
    {
        $this->middleware('auth');
        $this->fornecedor = $fornecedor;
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
        if(auth()->user()->can('Visualizar Fornecedores'))
        {

            return view('fornecedor.index');
        }
        else
        {
            return view('errors.401');
        }   
    }

    public function fornecedorList()
    {
        //
        if(auth()->user()->can('Visualizar Fornecedores'))
        {

        $fornecedores = DB::table('fornecedors')
            ->select([
                'fornecedors.id as id',
                'fornecedors.status as status',
                'fornecedors.nome_fantasia as nome_fantasia',
                'fornecedors.razao_social as razao_social',
                'fornecedors.tel_1 as tel_1',
                'fornecedors.email as email'
            ])
            ->where( function ($q) {
                $q->whereNull("status")
                ->orwhere("status", 1);
                } );

        return datatables()->of($fornecedores)
        ->addColumn('details', function($row) {
                return '
                    <div class="btn-group">
                         <button type="button" class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Ações <span class="caret"></span></button>
                         <ul class="dropdown-menu" role="menu" style="right: 0 !important; left: auto;">
                            <li>
                                <a href="fornecedor/'. $row->id .'">Detalhes</a>
                            </li>   
                            <li>
                                <a href="fornecedor/'.$row->id.'/edit">Editar</a>
                            </li>
                            <li class="divider"></li> 
                            <li> 
                               <a href="fornecedor/delete/'.$row->id.'">Desabilitar</a>
                            </li>  
                         </ul>
                      </div>
                    ';})
        ->rawColumns(['details'])
        ->make(true);
        }
    }

    public function disabled()
    {
        //
        if(auth()->user()->can('Visualizar Fornecedores'))
        {

            return view('fornecedor.index');
        }
        else
        {
            return view('errors.401');
        }   
    }

    public function fornecedorListDisabled()
    {
        //
        if(auth()->user()->can('Visualizar Fornecedores'))
        {

        $fornecedores = DB::table('fornecedors')
            ->select([
                'fornecedors.id as id',
                'fornecedors.status as status',
                'fornecedors.nome_fantasia as nome_fantasia',
                'fornecedors.razao_social as razao_social',
                'fornecedors.tel_1 as tel_1',
                'fornecedors.email as email'
            ])
            ->where( function ($q) {
                $q->orwhere("status", 0);
                } );

        return datatables()->of($fornecedores)
        ->addColumn('details', function($row) {
                return '
                    <div class="btn-group">
                         <button type="button" class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Ações <span class="caret"></span></button>
                         <ul class="dropdown-menu" role="menu" style="right: 0 !important; left: auto;">
                            <li>
                                <a href="fornecedor/'. $row->id .'">Detalhes</a>
                            </li>   
                            <li>
                                <a href="fornecedor/'.$row->id.'/edit">Editar</a>
                            </li>
                            <li class="divider"></li> 
                            <li> 
                               <a href="fornecedor/delete/'.$row->id.'">Desabilitar</a>
                            </li>  
                         </ul>
                      </div>
                    ';})
        ->rawColumns(['details'])
        ->make(true);
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
        if(auth()->user()->can('Criar Fornecedores'))
        {
            return view('fornecedor.create');
        }
        else
        {
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
        if(auth()->user()->can('Criar Fornecedores'))
        {
            $fornecedor                 = new Fornecedor;
            $fornecedor->nome_fantasia  = Input::get('nome_fantasia');
            $fornecedor->razao_social   = Input::get('razao_social');
            $fornecedor->cnpj           = Input::get('cnpj');
            $fornecedor->tel_1          = Input::get('tel_1');
            $fornecedor->tel_2          = Input::get('tel_2');
            $fornecedor->tel_3          = Input::get('tel_3');
            $fornecedor->email          = Input::get('email');
            $fornecedor->endereco       = Input::get('endereco');
            $fornecedor->cidade         = Input::get('cidade');
            $fornecedor->estado         = Input::get('estado');
            $fornecedor->pais           = Input::get('pais');
            $fornecedor->cep            = Input::get('cep');
            $fornecedor->site           = Input::get('site');
            $fornecedor->obs            = Input::get('obs');
            $fornecedor->save();

            toastr()->success('Fornecedor cadastrado com sucesso!', 'OK', ['timeOut' => 5000]);
            return redirect()->route('fornecedor.index');
        }
        else
        {
            return view('errors.401');
        }   
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Fornecedor  $fornecedor
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        //
        if(auth()->user()->can('Visualizar Fornecedores'))
        {
            $fornecedor = Fornecedor::where('id', $id)->get();
            return view('fornecedor.show',compact('fornecedor'));
        }
        else
        {
            return view('errors.401');
        }  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Fornecedor  $fornecedor
     * @return \Illuminate\Http\Response
     */
    public function edit(Fornecedor $fornecedor)
    {
        //
        if(auth()->user()->can('Editar Fornecedores'))
        {
            return view('fornecedor.edit',compact('fornecedor'));
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
     * @param  \App\Fornecedor  $fornecedor
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request, Fornecedor $fornecedor)
    {
        //
		 //
        if(auth()->user()->can('Editar Fornecedores')){
            $fornecedor                 		= Input::all();
			$fornecedorUpdate					= Fornecedor::find($id);
            $fornecedorUpdate->nome_fantasia  = $fornecedor['nome_fantasia'];
            $fornecedorUpdate->razao_social   = $fornecedor['razao_social'];
            $fornecedorUpdate->cnpj           = $fornecedor['cnpj'];
            $fornecedorUpdate->tel_1          = $fornecedor['tel_1'];
            $fornecedorUpdate->tel_2          = $fornecedor['tel_2'];
            $fornecedorUpdate->tel_3          = $fornecedor['tel_3'];
            $fornecedorUpdate->email          = $fornecedor['email'];
            $fornecedorUpdate->endereco       = $fornecedor['endereco'];
            $fornecedorUpdate->cidade         = $fornecedor['cidade'];
            $fornecedorUpdate->estado         = $fornecedor['estado'];
            $fornecedorUpdate->pais           = $fornecedor['pais'];
            $fornecedorUpdate->cep            = $fornecedor['cep'];
            $fornecedorUpdate->site           = $fornecedor['site'];
            $fornecedorUpdate->obs            = $fornecedor['obs'];
            $fornecedorUpdate->save();		

            toastr()->success('Fornecedor atualizado com sucesso!', 'Atualizado', ['timeOut' => 5000]);
            return redirect()->route('fornecedor.index');
        }
        else{
            return view('errors.401');
        }   
    }

   /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Fornecedor  $fornecedor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request, Fornecedor $fornecedor)
    {
        //
        if(auth()->user()->can('Remover Fornecedores')){
            $fornecedor = Fornecedor::find($id);
            $fornecedorUpdate = $fornecedor;
            $fornecedorUpdate->status = 0;
            $fornecedorUpdate->save();      

            toastr()->success('Fornecedor desabilitado com sucesso!', 'OK', ['timeOut' => 5000]);
            return redirect()->route('fornecedor.index');
        }
        else
        {
            return view('errors.401');
        }   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Fornecedor  $fornecedor
     * @return \Illuminate\Http\Response
     */
    public function active($id, Request $request, Fornecedor $fornecedor)
    {
        //
        if(auth()->user()->can('Remover Fornecedores')){
            $fornecedor = Fornecedor::find($id);
            $fornecedorUpdate = $fornecedor;
            $fornecedorUpdate->status = null;
            $fornecedorUpdate->save();      

            toastr()->success('Fornecedor habilitado com sucesso!', 'OK', ['timeOut' => 5000]);
            return redirect()->route('fornecedor.index');
        }
        else
        {
            return view('errors.401');
        }   
    }

    public function searchFornecedor(Request $request)
    {
        if(auth()->user()->can('Visualizar Fornecedores')){
            $data = [];

            if($request->has('q')){
                $search = $request->q;
                $data = DB::table("fornecedors")
                        ->select("id","nome_fantasia")
                        ->where('nome_fantasia','LIKE',"%$search%")
                        ->get();
            }
            return response()->json($data);
        }else{
            return view('errors.401');
        }
    }

}
