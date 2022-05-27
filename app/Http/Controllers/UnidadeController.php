<?php

namespace App\Http\Controllers;

use App\Models\Unidade;
use Illuminate\Http\Request;
use Toastr;
use Illuminate\Support\Facades\Request as Input;

class UnidadeController extends Controller
{
    protected   $request;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getBlcoos(Unidade $unidade)
    {
        return $unidade->blocos()->select('id', 'name')->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $unidades = Unidade::get();

        return view('unidade.index',compact('unidades'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        return view('unidade.create');
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
            'name' => 'required | unique:unidades',
        ]);

        //insert post data
        Unidade::create($request->all());

        toastr()->success('Unidade registrada com sucesso!', 'OK', ['timeOut' => 5000]);
        return redirect()->route('unidade.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Unidade  $unidade
     * @return \Illuminate\Http\Response
     */
    public function show(Unidade $unidade)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Unidade  $unidade
     * @return \Illuminate\Http\Response
     */
    public function edit(Unidade $unidade)
    {
        //
        return view('unidade.edit', compact('unidade'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Unidade  $unidade
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Unidade $unidade)
    {
        //
        $unidades = Unidade::get();
        $unidade->update($request->all());
        return view('unidade.index', compact('unidade', 'unidades'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Unidade  $unidade
     * @return \Illuminate\Http\Response
     */
    public function destroy(Unidade $unidade)
    {
        //
    }
}
