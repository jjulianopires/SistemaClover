@extends('adminlte::page')

@section('content')

<div class="col-12" style="padding: 10px;">
    <a href="{{route('voltar-painel')}}" title="Voltar para página do projeto" class="btn btn-success">Meu Projeto</a>
</div>

<div class="col s12">

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">US {{$id}} - {{$registro->descricao}}</h3>
        </div>
        @include('tarefas.kanban-us')

        <!-- @include('tarefas.kanban-original') -->

    </div>
</div>
</div>
</div>
</div>
</div>

<main class="py-4">
    @yield('content')
</main>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@endsection