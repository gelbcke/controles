<?php

namespace App\Http\Controllers;

use Spatie\Activitylog\Models\Activity;
use Illuminate\Http\Request;
use DB, Route;

class LogController extends Controller
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
        if(auth()->user()->can('Visualizar Log')){
    		$latestActivities = Activity::latest()->paginate(50);

    		return view('log.index',compact('latestActivities'));

        }else{
            return view('errors.401');
        } 
	}

    
    public function logList(Activity $activity, Request $request)
    {
        //
   
        if(auth()->user()->can('Visualizar Log')){
            $latestActivities = DB::table('activity_log')
                ->select([
                    'activity_log.id as id',
                    'activity_log.log_name as log_name',
                    'activity_log.description as description',
                    'activity_log.causer_id as causer_id',
                    'activity_log.created_at as created_at',
                ]);

            return datatables()->of($latestActivities)
                ->editColumn('created_at', function ($latestActivities) 
                {
                        return  date('d/m/Y - H:i', strtotime($latestActivities->created_at) ) ;
              })
                ->rawColumns(['created_at'])
                ->make(true);
        }else{
            return view('errors.401');
        } 
    }

    public function logListInfo(Activity $activity, Request $request)
    {
        //
   
        if(auth()->user()->can('Visualizar Log')){
            $latestActivities = DB::table('activity_log')
                ->select([
                    'activity_log.id as id',
                    'activity_log.log_name as log_name',
                    'activity_log.description as description',
                    'activity_log.causer_id as causer_id',
                    'activity_log.created_at as created_at',
                ])
                 ->where( function ($q) {
                    $q->where("activity_log.log_name", "Info");
                } );

            return datatables()->of($latestActivities)
                ->editColumn('created_at', function ($latestActivities) 
                {
                        return  date('d/m/Y - H:i', strtotime($latestActivities->created_at) ) ;
              })
                ->rawColumns(['created_at'])
                ->make(true);
        }else{
            return view('errors.401');
        } 
    }

    public function logListErro(Activity $activity, Request $request)
    {
        //
   
        if(auth()->user()->can('Visualizar Log')){
            $latestActivities = DB::table('activity_log')
                ->select([
                    'activity_log.id as id',
                    'activity_log.log_name as log_name',
                    'activity_log.description as description',
                    'activity_log.causer_id as causer_id',
                    'activity_log.created_at as created_at',
                ])
                ->where( function ($q) {
                    $q->where("activity_log.log_name", "Erro");
                } );

            return datatables()->of($latestActivities)
                ->editColumn('created_at', function ($latestActivities) 
                {
                        return  date('d/m/Y - H:i', strtotime($latestActivities->created_at) ) ;
              })
                ->rawColumns(['created_at'])
                ->make(true);
        }else{
            return view('errors.401');
        } 
    }

    public function logListBug(Activity $activity, Request $request)
    {
        //
   
        if(auth()->user()->can('Visualizar Log')){
            $latestActivities = DB::table('activity_log')
                ->select([
                    'activity_log.id as id',
                    'activity_log.log_name as log_name',
                    'activity_log.description as description',
                    'activity_log.causer_id as causer_id',
                    'activity_log.created_at as created_at',
                ])
                ->where( function ($q) {
                    $q->where("activity_log.log_name", "Bug");
                } );

            return datatables()->of($latestActivities)
                ->editColumn('created_at', function ($latestActivities) 
                {
                        return  date('d/m/Y - H:i', strtotime($latestActivities->created_at) ) ;
              })
                ->rawColumns(['created_at'])
                ->make(true);
        }else{
            return view('errors.401');
        } 
    }

    public function logListAlerta(Activity $activity, Request $request)
    {
        //
   
        if(auth()->user()->can('Visualizar Log')){
            $latestActivities = DB::table('activity_log')
                ->select([
                    'activity_log.id as id',
                    'activity_log.log_name as log_name',
                    'activity_log.description as description',
                    'activity_log.causer_id as causer_id',
                    'activity_log.created_at as created_at',
                ])
                ->where( function ($q) {
                    $q->where("activity_log.log_name", "Alerta");
                } );

            return datatables()->of($latestActivities)
                ->editColumn('created_at', function ($latestActivities) 
                {
                        return  date('d/m/Y - H:i', strtotime($latestActivities->created_at) ) ;
              })
                ->rawColumns(['created_at'])
                ->make(true);
        }else{
            return view('errors.401');
        } 
    }




}