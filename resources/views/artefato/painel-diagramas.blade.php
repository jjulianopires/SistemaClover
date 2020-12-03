@extends('adminlte::page')

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/canvg/1.5/canvg.min.js"></script>
<style>
    #div-texto {
        position: relative;
        border-width: 2px;
        width: 30%;
        height: 100%;
        left: 0px;
        background-color: white;
        float: left;
    }

    #painelDiagrama {
        position: relative;
        border-width: 2px;
        width: 70%;
        height: 100%;
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
                <h3 class="card-title">Criar Diagrama</h3>
            </div>
            <form action="{{ route('salvar-diagrama')}}" method="post" id="formDiagramas" enctype="multipart/form-data">
                {{ csrf_field() }}

                @if(isset($registro))
                <input type="hidden" name="idDiagrama" id="idDiagrama" value="{{$registro->id}}" />
                <input type="hidden" name="nomeDiagrama" id="nomeDiagrama" value="{{$registro->nome}}" />
                @endif

                <div class="card-body">

                    <div id="div-texto">
                        <label for="labelTexto">Especificação do Diagrama</label>
                        <textarea id="textAreaTexto" name="descricaoDiagrama" required>

                        </textarea>
                    </div>

                    <div id="painelDiagrama">
                        <div id="graphDivContainer"></div>
                    </div>
                </div>
                <!-- /.card-body -->

                <canvas id="canvas" style="display: none;"></canvas>
                <img src="" id="img" style="display: none;">

        </div>
    </div>
    <!-- /.card -->

    <div class="col-12">
        <a href="{{route('voltar-painel')}}" class="btn btn-secondary">Voltar</a>
        <a onclick="atualizarPainel()" style="margin-left: 15px; color: white" class="btn btn-primary">Atualizar Painel do Diagrama</a>
        <a id="btnDownload" style="margin-left: 15px; color: white" class="btn btn-primary">Download do Diagrama</a>
        <input type="submit" value="Salvar Diagrama" class="btn btn-success float-right">


    </div>
</div>
</form>
<main class="py-4">
    @yield('content')
</main>
<!-- /.content -->

<!-- script para inicializar o mermaid -->
<script src="https://unpkg.com/mermaid@8.4.3/dist/mermaid.min.js"></script>

<script>
    function atualizarPainel() {
        textoDiagrama = document.getElementById('textAreaTexto').value;
        var element = document.getElementById("graphDivContainer");
        var insertSvg = function(svgCode, bindFunctions) {
            element.innerHTML = svgCode;
            return element;
        };
        var graphDefinition = textoDiagrama;
        var graph = mermaid.mermaidAPI.render('graphDiv', graphDefinition, insertSvg, element);

    }
</script>

<script>
    (function() {
        mermaid.mermaidAPI.initialize({
            'startOnLoad': true
        });
        // Example of using the API
        var element = document.getElementById("graphDivContainer");
        var insertSvg = function(svgCode, bindFunctions) {
            element.innerHTML = svgCode;
            return element;
        };
        var graficoInicial = '{!!$diagrama!!}';
        document.getElementById('textAreaTexto').value = graficoInicial;
        var graph = mermaid.mermaidAPI.render('graphDiv', graficoInicial, insertSvg, element);
    })();
</script>

<script>
    btnDownload.addEventListener("click", function() {
        const graphDiv = document.getElementById('graphDiv');
        var xml = new XMLSerializer().serializeToString(graphDiv);
        var svg64 = btoa(xml); //for utf8: btoa(unescape(encodeURIComponent(xml)))
        var b64start = 'data:image/svg+xml;base64,';
        var image64 = b64start + svg64;

        img.onload = function() {
            // draw the image onto the canvas
            canvas.getContext('2d').drawImage(img, 0, 0);
        }
        img.src = image64;

        console.log(img);

        const a = document.createElement("a");
        a.href = img.src;
        a.download = "Diagrama";
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    });

    // function base64_to_jpeg($base64_string, $output_file) {
    //     $ifp = fopen($output_file, 'wb');
    //     $data = explode(',', $base64_string);
    //     fwrite($ifp, base64_decode($data[1]));
    //     fclose($ifp);
    //     return $output_file;
    // }

    //     function download(data, filename, type) {
    //         var file = new Blob([data], {
    //             type: type
    //         });
    //         if (window.navigator.msSaveOrOpenBlob) // IE10+
    //             window.navigator.msSaveOrOpenBlob(file, filename);
    //         else { // Others
    //             var a = document.createElement("a"),
    //                 url = URL.createObjectURL(file);
    //             a.href = url;
    //             a.download = filename;
    //             document.body.appendChild(a);
    //             a.click();
    //             setTimeout(function() {
    //                 document.body.removeChild(a);
    //                 window.URL.revokeObjectURL(url);
    //             }, 0);
    //         }
    //     }
    // 
</script>


@endsection