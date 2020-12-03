@extends('adminlte::page')

@section('content')

@if(Session::has('success'))
<script>
    window.onload = function() {
        sucesso();
    };

    function sucesso() {
        swal({
            title: "{!!session()->get('success')!!}",
            icon: 'success'
        })
        sessionStorage.setItem("success", "");
    }
</script>
@elseif(Session::has('error'))
<script>
    window.onload = function() {
        erro();
    };

    function erro() {
        swal({
            title: "{!!session()->get('error')!!}",
            icon: 'error'
        })
        sessionStorage.setItem("error", "");
    }
</script>
@elseif(Session::has('warning'))
<script>
    window.onload = function() {
        warning();
    };

    function warning() {
        swal({
            title: "{!!session()->get('warning')!!}",
            icon: 'warning'
        })
        sessionStorage.setItem("warning", null);
    }
</script>
@endif

<!-- Main content -->
<div class="col-md-10">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Atualizar dados do projeto</h3>
        </div>
        <form action="{{ route('atualizar-projeto')}}" method="post">
            {{ csrf_field() }}

            <input type="hidden" id="dono" name="dono" value="{{$registro->owner->login}}">

            <input type="hidden" id="nomeRepositorio" name="nomeRepositorio" value="{{$registro->name}}">

            <div class="card-body">
                <div class="form-group">
                    <label for="inputName">Nome do projeto</label>
                    <input type="text" id="inputName" name="nome" value="{{isset($registro->name) ? $registro->name : ''}}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="inputDescription">Descrição do projeto</label>
                    <textarea id="inputDescription" name="descricao" value="{{isset($registro->description) ? $registro->description : ''}}" class="form-control" rows="4" required>{{isset($registro->description) ? $registro->description : ''}}</textarea>
                </div>
                <div class="form-group">
                    <label for="inputStatus">Tipo do repositório</label>
                    <select name="tipo" id="tipo" class="form-control custom-select" required>
                        @if ($registro->private)
                        <option value="0">Público</option>
                        <option selected value="1">Privado</option>
                        @else
                        <option selected value="0">Público</option>
                        <option value="1">Privado</option>
                        @endif
                    </select>
                </div>
            </div>
            <!-- /.card-body -->

    </div>
    <!-- /.card -->
    <div class="col-12">
        <a href="{{route('home')}}" class="btn btn-secondary">Cancel</a>
        <input type="submit" value="Finalizar Edição" class="btn btn-success float-right">
    </div>
</div>
</form>
<main class="py-4">
    @yield('content')
</main>
<!-- /.content -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@endsection