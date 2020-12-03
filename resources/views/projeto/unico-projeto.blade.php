@extends('adminlte::page')


@section('content')

<!-- Content Wrapper. Contains page content -->

<!-- Main content -->

@if(Session::has('success'))
<script>
    window.onload = function() {
        sucesso();
        sessionStorage.setItem("success", " ");
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
        sessionStorage.setItem("error", " ");
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
        sessionStorage.setItem("warning", " ");
    }
</script>
@endif


<section class="content">

    <h3 class="title">Meu Projeto</h3>

    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{$numHistorias}}</h3>

                    <p>Histórias de Usuário</p>
                </div>
                <div class="icon">
                    <i class="fas fa-book"></i>
                </div>
                <a href="{{route('painel-us')}}" class="small-box-footer">
                    Abrir Painel <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>+</h3>
                    <p>Diagrama de fluxo</p>
                </div>
                <div class="icon">
                    <i class="fas fa-project-diagram"></i>
                </div>
                <a href="{{route('painel-diagrama', 1)}}" class="small-box-footer">
                    Criar diagrama <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>+</h3>
                    <p>Diagrama de Classe</p>
                </div>
                <div class="icon">
                    <i class="fas fa-project-diagram"></i>
                    <!-- <i class="fas fa-puzzle-piece"></i> -->
                </div>
                <a href="{{route('painel-diagrama', 2)}}" class="small-box-footer">
                    Criar diagrama <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>+</h3>
                    <p>Diagrama de Estados</p>
                </div>
                <div class="icon">
                    <i class="fas fa-project-diagram"></i>
                </div>
                <a href="{{route('painel-diagrama', 3)}}" class="small-box-footer">
                    Criar diagrama <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>


    <!-- Default box -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Artefatos do Projeto</h3>
        </div>
        <div class="card-body">

            <div class="row">
                <!-- <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Estimated budget</span>
                                    <span class="info-box-number text-center text-muted mb-0">2300</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Total amount spent</span>
                                    <span class="info-box-number text-center text-muted mb-0">2000</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Estimated project duration</span>
                                    <span class="info-box-number text-center text-muted mb-0">20 <span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h4>Recent Activity</h4>
                            <div class="post">
                                <div class="user-block">
                                    <img alt="Avatar" width="30" style="border-radius: 50%" src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcQTXpzxQHiZuJqWbNBHTQ4d0xg_mCZfWvPP4m2e9R0DhpWUFmP7&usqp=CAU">
                                    <span class="username">
                                        <a href="#">Jonathan Burke Jr.</a>
                                    </span>
                                    <span class="description">Shared publicly - 7:45 PM today</span>
                                </div>
                              
                                <p>
                                    Lorem ipsum represents a long-held tradition for designers,
                                    typographers and the like. Some people hate it and argue for
                                    its demise, but others ignore.
                                </p>

                                <p>
                                    <a href="#" class="link-black text-sm"><i class="fas fa-link mr-1"></i> Demo File 1 v2</a>
                                </p>
                            </div>

                            <div class="post clearfix">
                                <div class="user-block">
                                    <img alt="Avatar" width="30" style="border-radius: 50%" src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcQTcNrQj4LRFsJxyOv_L8ovgODPO9wueTQUdMHzzhCrKX5muE8w&usqp=CAU">
                                    <span class="username">
                                        <a href="#">Sarah Ross</a>
                                    </span>
                                    <span class="description">Sent you a message - 3 days ago</span>
                                </div>
                               
                                <p>
                                    Lorem ipsum represents a long-held tradition for designers,
                                    typographers and the like. Some people hate it and argue for
                                    its demise, but others ignore.
                                </p>
                                <p>
                                    <a href="#" class="link-black text-sm"><i class="fas fa-link mr-1"></i> Demo File 2</a>
                                </p>
                            </div>

                            <div class="post">
                                <div class="user-block">
                                    <img alt="Avatar" width="30" style="border-radius: 50%" src="https://cdn.iconscout.com/icon/free/png-512/avatar-368-456320.png">
                                    <span class="username">
                                        <a href="#">Jonathan Burke Jr.</a>
                                    </span>
                                    <span class="description">Shared publicly - 5 days ago</span>
                                </div>
                                
                                <p>
                                    Lorem ipsum represents a long-held tradition for designers,
                                    typographers and the like. Some people hate it and argue for
                                    its demise, but others ignore.
                                </p>

                                <p>
                                    <a href="#" class="link-black text-sm"><i class="fas fa-link mr-1"></i> Demo File 1 v1</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div> -->


                <div class="card card-info" style="width: 100%;">
                    <div class="card-header">
                        <h3 class="card-title">Diagramas</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th style="text-align: center;">Requisito Associado</th>
                                    <th style="text-align: center;">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($diagramas as $diagrama)
                                <tr>
                                    <td>{{$diagrama->nome}}</td>
                                    @if(isset($diagrama->us_id))
                                    @foreach($historias as $historia)
                                    @if($historia->id == $diagrama->us_id)
                                    <td style="width:70%">US{{$historia->id}}: {{$historia->descricao}}</td>
                                    @endif
                                    @endforeach
                                    @else
                                    <td style="text-align: center;">Nenhum requisito associado</td>
                                    @endif
                                    <td class="text-right py-0 align-middle">
                                        <!-- <div class="btn-group btn-group-sm">
                                        </div> -->
                                        @if(isset($diagrama->us_id))
                                        <a href="{{route('remover-associacao-diagrama', $diagrama->id)}}" title="Remover associação do diagrama com o requisito" class="btn btn-warning"><i class="fa fa-minus-circle"></i></a>
                                        @else
                                        <a onclick="associarRequisito(id)" id="{{$diagrama->id}}" title="Associar diagrama ao requisito" class="btn btn-success"><i class="fa fa-link"></i></a>
                                        @endif

                                        <a href="{{route('abrir-diagrama', $diagrama->id)}}" title="Visualizar diagrama" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                        <a href="{{route('deletar-diagrama', $diagrama->id)}}" title="Excluir diagrama" class="btn btn-danger"><i class="fas fa-trash"></i></a>

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

    <!-- MODAL DE ASSOCIAÇÃO REQUISITO -->
    <div class="modal fade" id="modal-associacao">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Associar Requisito ao Diagrama</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form id="form-associar-requisito" action="{{route('associar-requisito')}}" method="post">
                        {{ csrf_field() }}

                        <div class="card-body">

                            <div>
                                <label for="inputName">História de Usuário</label>
                                <select class="form-control" id="select_historias" name="us_id" required>
                                </select>
                            </div>

                            <input type="hidden" id="idDiagramaAssociacao" name="idDiagramaAssociacao" value="">

                        </div>

                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                            <input type="submit" value="Associar" class="btn btn-success float-right">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- fim modal -->

    <script>
        function associarRequisito(id) {

            console.log('id', id);
            historias = JSON.parse('{!! json_encode($historias)!!}');
            console.log(historias);

            select = document.getElementById("select_historias");
            console.log(select);

            diagramaAssociacao = document.getElementById("idDiagramaAssociacao");
            console.log(diagramaAssociacao);
            diagramaAssociacao.value = id;

            opcoes = "";

            for (const key in historias) {
                console.log(historias[key].id);
                opcoes = opcoes + '<option value="' + historias[key].id + '">' + historias[key].descricao + '</option>';

            }

            select.innerHTML = opcoes;

            $("#modal-associacao").modal({
                show: true
            });
        }
    </script>
</section>
<!-- /.content -->
<!-- /.content-wrapper -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@endsection