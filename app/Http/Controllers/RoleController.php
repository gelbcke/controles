<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;

class RoleController extends Controller
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
        $roles = Role::all();
        $users_roles = User::with('roles')->get();
        return view('roles.index',compact('roles', 'users_roles'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(auth()->user()->can('Criar Grupos')){
            $permissions = Permission::orderBy('name')->get();//Get all permissions
            return view('roles.create', compact('permissions'));
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
        if(auth()->user()->can('Criar Grupos')){
            $this->validate($request, [
                'name'=>'required|unique:roles|max:20',
                'permissions' =>'required',
                ]
            );
            $role = new Role();
            $role->name = $request->name;
            $role->save();
            if($request->permissions <> ''){
                $role->permissions()->attach($request->permissions);
            }
            return redirect()->route('roles.index')->with('success','Roles added successfully');
        }
        else{
            return view('errors.401');
        }
    }
   
     public function edit($id) 
     {
        if(auth()->user()->can('Editar Grupos')){
            $role = Role::findOrFail($id);
            $permissions = Permission::orderBy('name')->get();
            return view('roles.edit', compact('role', 'permissions'));
        }
        else{
            return view('errors.401');
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(auth()->user()->can('Editar Grupos')){
            $role = Role::findOrFail($id);//Get role with the given id
            //Validate name and permission fields
            $this->validate($request, [
                'name'=>'required|max:20|unique:roles,name,'.$id,
                'permissions' =>'required',
            ]);
            $input = $request->except(['permissions']);
            $role->fill($input)->save();
            if($request->permissions <> ''){
                $role->permissions()->sync($request->permissions);
            }
            return redirect()->route('roles.index')->with('success','Roles updated successfully');
        }
        else{
            return view('errors.401');
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(auth()->user()->can('Remover Grupos')){
            $role = Role::findOrFail($id);
            $role->delete();
            return redirect()->route('roles.index')
                ->with('success',
                 'Role deleted successfully!');
        }
        else{
            return view('errors.401');
        }
    }
}