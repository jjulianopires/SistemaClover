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
        sessionStorage.setItem("warning", "");
    }
</script>
@endif
<!-- Main content -->
<div class="col-md-10">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Criar projeto</h3>
        </div>
        <form action="{{ route('cadastrar-projeto')}}" method="post">
            {{ csrf_field() }}

            <div class="card-body">
                <div class="form-group">
                    <label for="inputName">Nome do projeto</label>
                    <input type="text" id="inputName" name="nome" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="inputDescription">Descrição do projeto</label>
                    <textarea id="inputDescription" name="descricao" class="form-control" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <label for="inputStatus">Tipo do repositório</label>
                    <select name="tipo" id="tipo" class="form-control custom-select" required>
                        <option value="" selected disabled>Selecione</option>
                        <option value="0">Público</option>
                        <option value="1">Privado</option>
                    </select>
                </div>
            </div>
            <!-- /.card-body -->

    </div>
    <!-- /.card -->
    <div class="col-12">
        <a href="{{route('home')}}" class="btn btn-secondary">Cancelar</a>
        <input type="submit" value="Finalizar Cadastro" class="btn btn-success float-right">
    </div>
</div>
</form>
<main class="py-4">
    @yield('content')
</main>
<!-- /.content -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@endsection