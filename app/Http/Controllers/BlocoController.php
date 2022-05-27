<?php

namespace App\Http\Controllers;

use App\Models\Bloco;
use App\Models\Unidade;
use Illuminate\Http\Request;
use Toastr;
use Illuminate\Support\Facades\Request as Input;

class BlocoController extends Controller
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
        $blocos = Bloco::get();

        return view('bloco.index',compact('blocos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $unidades = Unidade::all();
        return view('bloco.create',compact('unidades'));
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
        $this->validate($request, [
            'name' => 'required',
            'unidade_id' => 'required'
        ]);

        //insert post data
        Bloco::create($request->all());

        toastr()->success('Bloco cadastrado com sucesso!', 'OK', ['timeOut' => 5000]);
        return redirect()->route('bloco.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bloco  $bloco
     * @return \Illuminate\Http\Response
     */
    public function show(Bloco $bloco)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bloco  $bloco
     * @return \Illuminate\Http\Response
     */
    public function edit(Bloco $bloco)
    {
        //
        $unidades = Unidade::all();
        return view('bloco.edit', compact('bloco', 'unidades'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bloco  $bloco
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bloco $bloco)
    {
        //
        $bloco->update($request->all());
        return view('bloco.index', compact('bloco'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bloco  $bloco
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bloco $bloco)
    {
        //
    }
}
