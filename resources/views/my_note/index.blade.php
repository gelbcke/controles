@extends('layouts.app')
@section('pageTitle', 'Minhas Notas')
@section('content')
<header class="page-header">
   <h2>My Notes</h2>
   <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
         <li>
            <a href="{{route('dashboard')}}">
            <i class="fa fa-home"></i>
            </a>
         </li>
         <li>
            <span>My Notes</span>
         </li>
      </ol>
      <a class="sidebar-right-toggle" data-open="sidebar-right">
      <i class="fa fa-chevron-left"></i>
      </a>
   </div>
</header>
<section class="panel">
   <header class="panel-heading">
      <div class="row">
         <div class="col-sm-6">
            <h2 style="margin-top: 10px;" class="panel-title">My Notes.</h2>
         </div>
         <div class="col-sm-6">
            <div class="text-right">
               <a href="{{route('my_note.create')}}">
               <button type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn btn-success" >
               <i class="fa fa-plus"></i> Registrar
               </button>
               </a>
            </div>
         </div>
      </div>
   </header>
   <div class="panel-body">
      <div class="table-responsive">
      <table class="table table-bordered table-striped mb-none" id="datatable-details">
         @if ($notes->count() > 0)
         <thead>
            <th width="170px">Data de Criação</th>
            <th>Nota</th>
            <th width="80px">Ações</th>
         </thead>
         <tbody>
            @foreach ($notes as $note)
            <tr>
               <td>{{ date('d/m/Y - H:i', strtotime($note->created_at)) }}</td>
               <td>{!! $note->note !!}</td>
               <form action="{{ route('my_note.destroy', $note->id) }}" method="POST">
                  @csrf
                  @method('DELETE')
                  <td>
                     <button type="submit" class="label label-danger" onclick="return confirm('Tem certeza que deseja apagar estes dados?')">Apagar</button>
                  </td>
               </form>
            </tr>
            @endforeach
            @else
            <tr>
               <center>
                  <h1><i class="far fa-sad-tear"></i></h1>
               <h4> Não há nenhuma nota registrada por você</h4>
            </center>
            </tr>
         </tbody>
         @endif
      </table>
   </div>
   </div>
</section>
@endsection
