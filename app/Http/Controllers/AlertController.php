<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use App\Models\SoftwareKey;
use App\Models\TermosResponsabilidade;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AlertController extends Controller
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
        $today              = Carbon::today()->startOfDay();
        $future_expire      = Carbon::today()->startOfDay()->addWeek(4);

        $soft_key_expired   = SoftwareKey::where('due_date', '<' , $today)
								->whereNull('status')
                                ->get();

        $soft_key_wexpire   = SoftwareKey::whereBetween('due_date', [$today, $future_expire])
								->whereNull('status')
                                ->get();

        $termo_expired      = TermosResponsabilidade::whereNull('status')->where('dt_entrega', '<', $today)
                                ->get();

        $alertas = Alert::get();

        return view('alertas.index', compact('soft_key_expired', 'soft_key_wexpire', 'alertas', 'termo_expired'));
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
     * @param  \App\Alert  $alert
     * @return \Illuminate\Http\Response
     */
    public function show(Alert $alert)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Alert  $alert
     * @return \Illuminate\Http\Response
     */
    public function edit(Alert $alert)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Alert  $alert
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Alert $alert)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Alert  $alert
     * @return \Illuminate\Http\Response
     */
    public function destroy(Alert $alert)
    {
        //
    }
}
