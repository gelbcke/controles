<?php

namespace App\Http\Controllers;

use App\Models\Catraca;
use Illuminate\Http\Request;

class CatracaController extends Controller
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
     * @param  \App\Catraca  $catraca
     * @return \Illuminate\Http\Response
     */
    public function show(Catraca $catraca)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Catraca  $catraca
     * @return \Illuminate\Http\Response
     */
    public function edit(Catraca $catraca)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Catraca  $catraca
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Catraca $catraca)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Catraca  $catraca
     * @return \Illuminate\Http\Response
     */
    public function destroy(Catraca $catraca)
    {
        //
    }
}
