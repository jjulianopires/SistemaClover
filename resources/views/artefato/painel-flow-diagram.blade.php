@extends('adminlte::page')

@section('content')
<style>
    #div-texto {
        position: relative;
        border-width: 2px;
        width: 35%;
        height: 500px;
        left: 0px;
        background-color: white;
        float: left;
    }

    #painelDiagrama {
        position: relative;
        border-width: 2px;
        width: 65%;
        height: 500px;
        background-color: peachpuff;
        float: left;
        padding-left: 5%;
        padding-top: 5%;
    }

    #labelTexto {
        position: relative;
        border-width: 2px;
        width: 100%;
    }

    #textAreaTexto {
        position: relative;
        border-width: 2px;
        width: 100%;
        height: 450px;
    }

    .group:before,
    .group:after {
        content: "";
        display: table;
    }

    .group:after {
        clear: both;
    }

    .group {
        zoom: 1;
        /* For IE 6/7 (trigger hasLayout) */
    }
</style>

<!-- Main content -->
<div class="row">

    <div class="col s12 m12 l12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Criar Diagrama de Fluxo</h3>
            </div>
            <form action="{{ route('cadastrar-projeto')}}" method="post">
                {{ csrf_field() }}

                <div class="card-body">

                    <div id="div-texto">
                        <label for="labelTexto">Especificação do Diagrama</label>
                        <textarea id="textAreaTexto" name="descricaoDiagrama" onkeypress="atualizarPainel()" required></textarea>
                    </div>

                    <div class="mermaid" id="painelDiagrama">
                        graph TD
                        A[Christmas] -->|Get money| B(Go shopping)
                        B --> C{Let me think}
                        C -->|One| D[Laptop]
                        C -->|Two| E[iPhone]
                        C -->|Three| F[fa:fa-car Car]
                    </div>
                </div>
                <!-- /.card-body -->
        </div>
    </div>
    <!-- /.card -->

    <div class="col-12">
        <a href="{{route('voltar-painel')}}" class="btn btn-secondary">Voltar</a>
        <input type="submit" value="Salvar Diagrama" class="btn btn-success float-right">
    </div>
</div>
</form>
<main class="py-4">
    @yield('content')
</main>
<!-- /.content -->

<script>
    function atualizarPainel() {
        console.log(event);
        painel = document.getElementById('textAreaTexto');
    }
</script>

<!-- script para inicializar o mermaid -->
<script src="https://cdn.jsdelivr.net/npm/mermaid/dist/mermaid.min.js"></script>
<script>
    mermaid.initialize({
        startOnLoad: true
    });
</script>
@endsection