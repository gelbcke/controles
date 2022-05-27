<?php
namespace App\Http\Controllers;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
class PermissionController extends Controller
{
    protected   $request;
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $permissions = Permission::orderBy('name')->get();
        return view('permissions.index',compact('permissions'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(auth()->user()->can('Criar Permissões')){
            $roles = Role::get(); //Get all roles
            return view('permissions.create',compact('roles'));
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
        if(auth()->user()->can('Criar Permissões')){
            $this->validate($request, [
                'name'=>'required|max:40',
            ]);
            $permission = new Permission();
            $permission->name = $request->name;
            $permission->save();
            if ($request->roles <> '') { 
                foreach ($request->roles as $key=>$value) {
                    $role = Role::find($value); 
                    $role->permissions()->attach($permission);
                }
            }
            return redirect()->route('permissions.create')->with('success','Permission added successfully');
        }
        else{
            return view('errors.401');
        } 
    }
   
    public function edit(Permission $permission)
    {   
        if(auth()->user()->can('Editar Permissões')){
            return view('permissions.edit', compact('permission'));
        }
        else{
            return view('errors.401');
        } 
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        if(auth()->user()->can('Editar Permissões')){
            $this->validate($request, [
                'name'=>'required',
            ]);
            $permission->name=$request->name;
            $permission->save();
            return redirect()->route('permissions.index')
                ->with('success',
                 'Permission'. $permission->name.' updated!');
        }
        else{
            return view('errors.401');
        } 
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        if(auth()->user()->can('Remover Permissões')){
            $permission->delete();
            return redirect()->route('permissions.index')
                ->with('success',
                 'Permission deleted successfully!');
        }
        else{
            return view('errors.401');
        } 
    }
}