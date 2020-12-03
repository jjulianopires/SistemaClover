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
    }
</script>
@endif

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Prototipo de Testes do Sistema Clover</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    {{ __('Você está logado!') }}
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