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
<div class="col-md-12">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Projeto - {{$projeto->name}}</h3>

        </div>
        <div class="col s12">
            <div class="card">

                <div class="card-header p-3 col s12">
                    <ul class="nav nav-pills">
                        <li class="tab col m6" class="nav-item"><a class="nav-link active" href="#cadastrar" data-toggle="tab">Criar História de Usuário</a></li>
                        <li class="tab col m6" class="nav-item"><a class="nav-link " href="#listar" data-toggle="tab">Listar Histórias de Usuário</a></li>

                    </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content col-12">
                        <div class=" active tab-pane" id="cadastrar">
                            <div class="active tab-pane">
                                @include('user-story.form-criar-us')

                            </div>
                        </div>

                        <div class=" tab-pane" id="listar">
                            <div class="post">
                                @include('user-story.tabela-us')
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<main class="py-4">
    @yield('content')
</main>
<!-- /.content -->

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@endsection