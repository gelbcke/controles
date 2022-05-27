<?php

namespace App\Http\Controllers;

use App\Models\HardwareHist;
use App\Models\Ambiente;
use Illuminate\Http\Request;

class HardwareHistController extends Controller
{
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
     * @param  \App\HardwareHist  $hardwareHist
     * @return \Illuminate\Http\Response
     */
    public function show($id, HardwareHist $hardwareHist, Ambiente $ambiente)
    {
        //
        if(auth()->user()->can('Visualizar Alterações de Hardware'))
        {
            $ambiente       = Ambiente::where('id', $id)
                            ->get();

            $hardware_hist  = HardwareHist::where('ambiente_id', $id)
                            ->orderBy('created_at', 'desc')
                            ->get();

            return view('ambiente/hardware_hist',compact('ambiente', 'hardware_hist', 'id', 'ambiente'));
        }
        else
        {
            return view('errors.401');
        } 

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\HardwareHist  $hardwareHist
     * @return \Illuminate\Http\Response
     */
    public function edit(HardwareHist $hardwareHist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\HardwareHist  $hardwareHist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HardwareHist $hardwareHist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\HardwareHist  $hardwareHist
     * @return \Illuminate\Http\Response
     */
    public function destroy(HardwareHist $hardwareHist)
    {
        //
    }
}
