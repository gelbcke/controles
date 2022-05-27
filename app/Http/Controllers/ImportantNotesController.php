<?php

namespace App\Http\Controllers;

use App\Models\ImportantNotes;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request as Input;

class ImportantNotesController extends Controller
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
        //
        if(auth()->user()->can('Visualizar Notas Importantes')){
            $notes = ImportantNotes::orderby('period_end', 'DESC')->get();

            return view('notas_importantes.index',compact('notes'));
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
    public function create()
    {
        //
        if(auth()->user()->can('Criar Notas Importantes')){
            return view ('notas_importantes.create');
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
        if(auth()->user()->can('Criar Notas Importantes')){
            $user_id = Auth::user()->id;

            $request->request->add([
                'user_id'       => $user_id,
                'period_start'  => Carbon::createFromFormat('d/m/Y',Input::get('period_start'))->format('Y-m-d'),
                'period_end'    => Carbon::createFromFormat('d/m/Y',Input::get('period_end'))->format('Y-m-d')
            ]);

            ImportantNotes::create($request->all());

            toastr()->success('Anotação registrada com sucesso!', 'OK', ['timeOut' => 5000]);
            return redirect()->route('notas_importantes.index');
        }
        else{
            return view('errors.401');
        }  
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ImportantNotes  $importantNotes
     * @return \Illuminate\Http\Response
     */
    public function show(ImportantNotes $importantNotes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ImportantNotes  $importantNotes
     * @return \Illuminate\Http\Response
     */
    public function edit(ImportantNotes $importantNotes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ImportantNotes  $importantNotes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ImportantNotes $importantNotes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ImportantNotes  $importantNotes
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, ImportantNotes $importantNotes)
    {
        //
        if(auth()->user()->can('Remover Notas Importantes')){
            ImportantNotes::find($id)->delete();
            toastr()->success('Anotação removida com sucesso!', 'OK', ['timeOut' => 5000]);
            return redirect()->route('notas_importantes.index');
        }
        else{
            return view('errors.401');
        }  
    }
}
