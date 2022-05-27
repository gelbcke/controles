<?php

namespace App\Http\Controllers;

use App\Models\SoftwareList;
use App\Models\Software;
use App\Models\Ambiente;
use App\Models\Imagem;
use App\Models\SoftwareKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as Input;
use Laravel\Scout\Searchable;
use Toastr, DB;

class SoftwareListController extends Controller
{
    private     $softwarelist;
    private     $name;
    protected   $request;

    public function __construct(Request $request, SoftwareList $softwarelist)
    {    
        $this->middleware('auth');
        $this->softwarelist = $softwarelist;
        $this->request = $request;
    }

    public function addMore()
    {
        return view("addMore");
    }

    public function search(Request $request, SoftwareList $softwarelist)
    {
        //  
        if(auth()->user()->can('Visualizar Softwares'))
        {          
            $search         = $request->input('application');
            $softwares      = Software::where('software_list_id', $request->input('application'))->get();
            $img_id         = Software::where('software_list_id', $request->input('application'))->pluck('imagem_id');      
            $ambientes      = Ambiente::whereNull('status')->whereIn('imagem_id', $img_id)->get();
            $name           = SoftwareList::where('id', $search)->value('name') ;     
            return view('softwarelist.search', compact('softwares', 'ambientes', 'img_id', 'search', 'name'));
        }
        else
        {
            return view('errors.401');
        }  
    }

    public function searchResponse(Request $request)
    {
        $query = $request->get('term','');

        $apps=\DB::table('software_lists');
        if($request->type=='name'){
            $apps->where('name','LIKE','%'.$query.'%');
        }
        $apps=$apps->get();        
        $data=array();
        
        foreach ($apps as $app) {
                $data[]=array('name'=>$app->name);
        }
        if(count($data))
             return $data;
        else
            return ['name'=>''];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if(auth()->user()->can('Visualizar Lista de Softwares')){
            $has_key = SoftwareKey::pluck('software_id');
            
            $softwarelists = SoftwareList::all();            

            return view('softwarelist.index',compact('softwarelists', 'has_key'));
        }else{
            return view('errors.401');
        } 
    }

    public function allKey()
    {
        //
        if(auth()->user()->can('Visualizar Lista de Softwares')){
            $has_key = SoftwareKey::pluck('software_id');

            $softwarelists = SoftwareList::whereIn('id', $has_key)->get();           

            return view('softwarelist.index',compact('softwarelists', 'has_key'));
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
        if(auth()->user()->can('Criar Lista de Softwares')){
            return view('softwarelist.create');
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
        if(auth()->user()->can('Criar Lista de Softwares')){

            $softwarelist = SoftwareList::get('name');

            for ($i = 0; $i < count($request->name); $i++) 
            {      
                //Verfica se o software já está no banco.
                $this->softwarelist->updateOrCreate([
                    'name' => $request->name[$i]
                ]);
            } 
            toastr()->success('Software(s) registrados com sucesso!', 'OK', ['timeOut' => 5000]);
            return redirect()->route('softwarelist.index');
           
        }else{
            return view('errors.401');
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SoftwareList  $softwareList
     * @return \Illuminate\Http\Response
     */
    public function show(SoftwareList $softwareList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SoftwareList  $softwareList
     * @return \Illuminate\Http\Response
     */
    public function edit(SoftwareList $softwareList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SoftwareList  $softwareList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SoftwareList $softwareList)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SoftwareList  $softwareList
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request, SoftwareList $softwareList)
    {
        //
        if(auth()->user()->can('Remover Lista de Softwares')){
            SoftwareList::find($id)->delete();
            
            toastr()->success('Software Removido com sucesso do sistema!', 'OK', ['timeOut' => 5000]);
            return redirect()->back();
        }else{
            return view('errors.401');
        } 
    }
}
