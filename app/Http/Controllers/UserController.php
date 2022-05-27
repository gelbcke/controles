<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Request as Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use \Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Bloco;
use App\Models\BlocoTecnico;
use App\Models\Unidade;
use App\Models\RevisaoAmbiente;
use Carbon\Carbon;
use DB;
use Toastr, Auth;

class UserController extends Controller
{
    use         RegistersUsers;
    private     $bloco_list;
    protected   $request;

    public function __construct(Request $request, BlocoTecnico $bloco_list)
    {
        $this->middleware('auth');
        $this->bloco_list = $bloco_list;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'      => 'required|max:255',
            'email'     => 'required|email|max:255|unique:users',
            'password'  => [
                                'required',
                                'min:6',
                                'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/'
                            ],
            'matricula' => 'required|unique:users',
        ]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if(auth()->user()->can('Visualizar Usuários')){
            $users      = User::orderby('name', 'asc')
                            ->where('status', 1)
                            ->get();
            return view('usuarios.index',compact('users'));
        }
        else{
            return view('errors.401');
        }
    }

    public function disabled(Request $request)
    {
        //
        if(auth()->user()->can('Visualizar Usuários')){
            $users      = User::orderby('name', 'asc')
                            ->where('status', '!=', 1)
                            ->get();
            return view('usuarios.index',compact('users'));
        }
        else{
            return view('errors.401');
        }
    }

   /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
   protected function create(Request $request)
   {
        //
        if(auth()->user()->can('Criar Usuários')){
            $roles          = Role::get();
            $blocos         = Bloco::all()->groupBy('unidade_id');
            $users          = User::where('status', 1)->orderBy('name')->get();
            $unidades       = Unidade::all()->sortBy('name');
            $unidades_name  = Unidade::orderBy('name');

            return view('usuarios.create', compact('roles', 'blocos','users', 'unidades', 'unidades_name'));
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
        if(auth()->user()->can('Criar Usuários')){
           $this->validate($request, [
            'name'      => 'required',
            'email'     => 'required|email|unique:users',
            'password'  => [
                                'required',
                                'min:6'
                            ],
            'matricula' => 'required|unique:users',
            'roles'     => 'required'
        ]);

           $usuario                     = new User;
           $usuario->name               = Input::get('name');
           $usuario->email              = Input::get('email');
           $usuario->matricula          = Input::get('matricula');
           $usuario->status             = Input::get('status');
           $usuario->telefone           = Input::get('telefone');
           $usuario->unidade_id         = Input::get('unidade_id');
           $usuario->periodo            = Input::get('periodo');
           $usuario->horario_de_entrada = Input::get('horario_de_entrada');
           $usuario->saida_intervalo    = Input::get('saida_intervalo');
           $usuario->retorno_intervalo  = Input::get('retorno_intervalo');
           $usuario->horario_de_saida   = Input::get('horario_de_saida');
           $usuario->cidade             = Input::get('cidade');
           $usuario->bairro             = Input::get('bairro');
           $usuario->endereco           = Input::get('endereco');
           $usuario->tipo_transporte    = Input::get('tipo_transporte');
           $usuario->lider_id           = Input::get('lider_id');
           $usuario->cargo              = Input::get('cargo');
           $usuario->admissao           = Input::get('admissao');
           $usuario->rg                 = Input::get('rg');
           $usuario->cpf                = Input::get('cpf');
           $usuario->password           = bcrypt(Input::get('password'));
           $usuario->save();


            //Insere no DB blocos de responsabilidade do usuário
            if(Input::has('bloco_id')){
                $bloco_list = BlocoTecnico::get(['bloco_id', 'user_id']);
                    for ($i = 0; $i < count($request->bloco_id); $i++)
                    {
                     $this->bloco_list->create([
                        'bloco_id'  => $request->bloco_id[$i],
                        'user_id'   => $usuario->id
                    ]);
                 }
             }

            //Define grupos de permissão
            if($request->roles <> ''){
                if(auth()->user()->can('Editar Permissões')){
                    $usuario->roles()->attach($request->roles);
                }else{
                    //caso o criador do usuário não possua acesso, coloca o usuário criado no grupo de usuários
                    $usuario->roles()->attach('1');
                }
            }

            toastr()->success('Usuário cadastrado com sucesso!', 'OK', ['timeOut' => 5000]);
            return redirect()->route('usuarios.index');
        }
        else{
            return view('errors.401');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id, User $user)
    {
        //
        if(auth()->user()->can('Visualizar Usuários')){
            $user                       = User::find($id);
            $bloco                      = BlocoTecnico::where('user_id', $user->id)->get();

            $total_revisao_mes_atual    = RevisaoAmbiente::where('user_id', $user->id)
                                            ->whereMonth('created_at', Carbon::now()->month)
                                            ->count();

            $total_revisao              = RevisaoAmbiente::where('user_id', $user->id)
                                            ->count();

            $total_revisao_fp_mes       = RevisaoAmbiente::where('user_id', $user->id)
                                            ->whereMonth('created_at', Carbon::now()->month)
                                            ->where('obs', 'LIKE', "%após o vencimento.%")
                                            ->count();

            $total_revisao_fp           = RevisaoAmbiente::where('user_id', $user->id)
                                            ->where('obs', 'LIKE', "%após o vencimento.%")
                                            ->count();

            return view('usuarios.meu_perfil', compact('user', 'bloco', 'total_revisao_mes_atual', 'total_revisao', 'total_revisao_fp', 'total_revisao_fp_mes'));
        }
        else{
            return view('errors.401');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function meu_perfil(User $user)
    {
        //
        $user                       = Auth::user();
        $bloco                      = BlocoTecnico::where('user_id', $user->id)->get();

        $created_at                 = RevisaoAmbiente::value('created_at');
        $updated_at                 = RevisaoAmbiente::value('updated_at');

        $total_revisao_mes_atual    = RevisaoAmbiente::where('user_id', $user->id)
                                        ->whereMonth('created_at', Carbon::now()->month)
                                        ->count();

        $total_revisao              = RevisaoAmbiente::where('user_id', $user->id)
                                        ->count();

        //Revisão fora do prazo no mês atual
        $total_revisao_fp_mes       = RevisaoAmbiente::where('user_id', $user->id)
                                        ->whereMonth('created_at', Carbon::now()->month)
                                        ->where('obs', 'LIKE', "%após o vencimento.%")
                                        ->count();

        //Revisões fora do prazo geral
        $total_revisao_fp           = RevisaoAmbiente::where('user_id', $user->id)
                                        ->where('obs', 'LIKE', "%após o vencimento.%")
                                        ->count();


        return view('usuarios.meu_perfil', compact('user', 'bloco', 'total_revisao_mes_atual', 'total_revisao', 'total_revisao_fp', 'total_revisao_fp_mes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        //
        if(auth()->user()->can('Editar Usuários')){
            $usuario        = User::findOrFail($id);
            $roles          = Role::get();
            $blocos         = Bloco::all()->groupBy('unidade_id');
            $bloco_teste    = BlocoTecnico::where('user_id', $id)->pluck('bloco_id');
            $users          = User::where('status', 1)->orderBy('name')->get();
            $unidades       = Unidade::all()->sortBy('name');
            $unidades_name  = Unidade::orderBy('name');
            $user_id        = Auth::user()->id;
            $bloco_get      = Bloco::get();
            return view('usuarios.edit',compact('bloco_teste', 'usuario', 'roles', 'blocos', 'bloco_get', 'users', 'unidades', 'unidades_name', 'user_id'));
        }
        else{
            return view('errors.401');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        //
       $this->validate($request, [
            'name'          => 'required',
            'email'         => 'required|email',
            'matricula'     => 'required',
            'roles'         => 'required'
        ]);

       if(auth()->user()->can('Editar Usuários')){
        $user                               = User::findOrFail($id);
        $usuario                            = Input::all();
        $usuarioUpdate                      = $user;
        $usuarioUpdate->name                = $usuario['name'];
        $usuarioUpdate->email               = $usuario['email'];
        $usuarioUpdate->matricula           = $usuario['matricula'];
        $usuarioUpdate->status              = 1;
        $usuarioUpdate->telefone            = $usuario['telefone'];
        $usuarioUpdate->unidade_id          = $usuario['unidade_id'];
        $usuarioUpdate->periodo             = $usuario['periodo'];
        $usuarioUpdate->horario_de_entrada  = $usuario['horario_de_entrada'];
        $usuarioUpdate->saida_intervalo     = $usuario['saida_intervalo'];
        $usuarioUpdate->retorno_intervalo   = $usuario['retorno_intervalo'];
        $usuarioUpdate->horario_de_saida    = $usuario['horario_de_saida'];
        $usuarioUpdate->cidade              = $usuario['cidade'];
        $usuarioUpdate->bairro              = $usuario['bairro'];
        $usuarioUpdate->endereco            = $usuario['endereco'];
        $usuarioUpdate->tipo_transporte     = $usuario['tipo_transporte'];

        if(Input::has('lider_id')){
            $usuarioUpdate->lider_id        = $usuario['lider_id'];
        }
        else{
            $usuarioUpdate->lider_id        = null;
        }

        $usuarioUpdate->cargo               = $usuario['cargo'];
        $usuarioUpdate->admissao            = $usuario['admissao'];
        $usuarioUpdate->rg                  = $usuario['rg'];
        $usuarioUpdate->cpf                 = $usuario['cpf'];
        $usuarioUpdate->save();

        if (Input::has('bloco_id')){
        //Insere no DB blocos de responsavbilidade do usuário
        BlocoTecnico::where('user_id', $id)->delete();
        $bloco_list = BlocoTecnico::get(['bloco_id', 'user_id']);
            for ($i = 0; $i < count($request->bloco_id); $i++)
            {
                $this->bloco_list->create([
                    'bloco_id'  => $request->bloco_id[$i],
                    'user_id'   => $id
                ]);
            }
        }
        $input = $request->except('roles');

        $user->fill($input)->save();

        if(auth()->user()->can('Editar Permissões')){
            if ($request->roles <> '') {
                $user->roles()->sync($request->roles);
            }
            else {
                $user->roles()->detach();
            }
        }
        else{
            //caso o criador do usuário não possua permissão, impede a alteração do grupo pelo value do input
        }
            toastr()->success('Usuário atualizado com sucesso!', 'OK', ['timeOut' => 5000]);
            return redirect()->route('usuarios.index');
        }
        else{
            return view('errors.401');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function deactive($id, Request $request, User $user)
    {
        //
        if(auth()->user()->can('Remover Usuários')){
            $user                   = User::find($id);
            $usuarioUpdate          = $user;
            $usuarioUpdate->status  = 0;
            $usuarioUpdate->save();

            // Faz logoff do usuário
            \Session::getHandler()->destroy($user->session_id);

            toastr()->success('Usuário desabilitado com sucesso!', 'OK', ['timeOut' => 5000]);
            return redirect()->route('usuarios.index');
        }
        else{
            return view('errors.401');
        }
    }

    /**
     * Active the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function active($id, Request $request, User $user)
    {
        //
        if(auth()->user()->can('Remover Usuários')){
            $user                   = User::find($id);
            $usuarioUpdate          = $user;
            $usuarioUpdate->status  = 1;
            $usuarioUpdate->save();

            toastr()->success('Usuário habilitado com sucesso!', 'OK', ['timeOut' => 5000]);
            return redirect()->route('usuarios.index');
        }
        else{
            return view('errors.401');
        }
    }

    public function lockscreen()
    {
        if (Auth::check()) {
            session(['lock-expires-at' => now()]);
            toastr()->info('Sistema Bloqueado!', 'OK', ['timeOut' => 5000, 'positionClass' => 'toast-top-center']);
            return redirect()->route('login.locked');
        }
    }

    public function config(Request $request, User $usuario)
    {
            $id                                 = Auth::user()->id;
            $user                               = User::findOrFail($id);
            $usuario                            = Input::all();
            $usuarioUpdate                      = $user;
            $usuarioUpdate->lockout_time        = $usuario['lockout_time'];
            $usuarioUpdate->save();
            toastr()->success('Atualizado com sucesso!', 'OK', ['timeOut' => 5000]);
            return redirect()->back();
    }
}
