<?php

namespace App\Http\Controllers;

use App\Models\BlocoTecnico;
use Illuminate\Http\Request;

class BlocoTecnicoController extends Controller
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
     * @param  \App\BlocoTecnico  $blocoTecnico
     * @return \Illuminate\Http\Response
     */
    public function show(BlocoTecnico $blocoTecnico)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BlocoTecnico  $blocoTecnico
     * @return \Illuminate\Http\Response
     */
    public function edit(BlocoTecnico $blocoTecnico)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BlocoTecnico  $blocoTecnico
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BlocoTecnico $blocoTecnico)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BlocoTecnico  $blocoTecnico
     * @return \Illuminate\Http\Response
     */
    public function destroy(BlocoTecnico $blocoTecnico)
    {
        //
    }
}
