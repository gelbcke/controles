@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Softwares do {{ $software->ambiente }}</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('software.index') }}"> Voltar</a>
            </div>
        </div>
    </div>

       <table class="table table-bordered">
        <tr>
            <th>Software</th>
            <th>Versão</th>
        </tr>
          @foreach ($software_lists as $software_list)
        <tr>
            <td>{{ $software_list->application }}</td>
            <td>{{ $software_list->version }}</td>
        </tr>
        @endforeach
    </table>

</div>
@endsection