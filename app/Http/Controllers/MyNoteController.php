<?php

namespace App\Http\Controllers;

use App\Models\MyNote;
use Illuminate\Http\Request;
use Auth, Alert;

class MyNoteController extends Controller
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
        $notes = MyNote::orderby('created_at', 'DESC')->where('user_id', Auth::user()->id)->get();

        return view('my_note.index',compact('notes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view ('my_note.create');
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
        $user_id = Auth::user()->id;
        $status = 1;

        $request->request->add(['user_id' => $user_id, 'status' => $status]);


        MyNote::create($request->all());

        toastr()->success('Anotação registrada com sucesso!', 'OK', ['timeOut' => 5000]);
        return redirect()->route('my_note.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MyNote  $myNote
     * @return \Illuminate\Http\Response
     */
    public function show(MyNote $myNote)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MyNote  $myNote
     * @return \Illuminate\Http\Response
     */
    public function edit(MyNote $myNote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MyNote  $myNote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MyNote $myNote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        MyNote::find($id)->delete();
        toastr()->success('Anotação removida com sucesso!', 'OK', ['timeOut' => 5000]);
        return redirect()->route('my_note.index');
    }
}
