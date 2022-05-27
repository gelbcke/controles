<?php

namespace App\Http\Controllers;

use App\Models\ProjetorModelo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as Input;
use DB, Auth, Toastr;

class ProjetorModeloController extends Controller
{
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
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProjetorModelo  $projetorModelo
     * @return \Illuminate\Http\Response
     */
    public function show(ProjetorModelo $projetorModelo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProjetorModelo  $projetorModelo
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, ProjetorModelo $projetorModelo)
    {
        //
        if(auth()->user()->can('Editar Projetores')){           

            return view('projetor.edit_model',compact('projetorModelo'));
        }
        else{
            return view('errors.401');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProjetorModelo  $projetorModelo
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request, ProjetorModelo $projetorModelo)
    {
        //
         if(auth()->user()->can('Editar Projetores')){
            // Atualiza os valores no DB
            $projetorModelo                             = Input::all();
            $projetorModeloUpdate                       = ProjetorModelo::findOrFail($id);
            $projetorModeloUpdate->fabricante           = $projetorModelo['fabricante'];
            $projetorModeloUpdate->modelo               = $projetorModelo['modelo'];
            $projetorModeloUpdate->pixels               = $projetorModelo['pixels'];
            $projetorModeloUpdate->lumens               = $projetorModelo['lumens'];
            $projetorModeloUpdate->max_resolution       = $projetorModelo['max_resolution'];
            $projetorModeloUpdate->lamp_max_time        = $projetorModelo['lamp_max_time'];
            $projetorModeloUpdate->distance_projection  = $projetorModelo['distance_projection'];
            $projetorModeloUpdate->max_screen_size      = $projetorModelo['max_screen_size'];
            $projetorModeloUpdate->contrast             = $projetorModelo['contrast'];
            $projetorModeloUpdate->color_reproduction   = $projetorModelo['color_reproduction'];
            $projetorModeloUpdate->sound                = $projetorModelo['sound'];
            $projetorModeloUpdate->projection_mode      = $projetorModelo['projection_mode'];
            $projetorModeloUpdate->energy_consumption   = $projetorModelo['energy_consumption'];
            $projetorModeloUpdate->weight               = $projetorModelo['weight'];
            $projetorModeloUpdate->wireless             = $projetorModelo['wireless'];

            $image                                      = $request->file('projector_image');

            if ($request->hasFile('projector_image')) {
                $extension                              = $image->getClientOriginalExtension();

                $projetorModeloUpdate->projector_image  = $projetorModeloUpdate->fabricante."_".$projetorModeloUpdate->modelo.".".$extension;
                $destinationPath                        = public_path('/images/projetores');       
                $image->move($destinationPath, $projetorModeloUpdate->fabricante."_".$projetorModeloUpdate->modelo.".".$extension);
            }else{
                $projetorModeloUpdate->projector_image;
            }

            $projetorModeloUpdate->save();      

            toastr()->success('Projetor atualizado com sucesso!', 'OK', ['timeOut' => 5000]);
            return redirect()->route('projetor.estatisticas');
        }
        else{
            return view('errors.401');
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProjetorModelo  $projetorModelo
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProjetorModelo $projetorModelo)
    {
        //
    }
}
