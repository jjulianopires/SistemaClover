<link rel="stylesheet" href="../../vendor/jkanban-master/dist/jkanban.min.css" />
<script src="../../vendor/jkanban-master/dist/jkanban.js"></script>

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

<style>
    #kanban-tarefas {
        overflow-x: auto;
        padding: 20px 0;
    }

    .success {
        background: #00b961;
    }

    .info {
        background: #2a92bf;
    }

    .warning {
        background: #f4ce46;
    }

    .error {
        background: #fb7d44;
    }
</style>


<div style="color:green; padding-left: 20px; padding-top: 25px;">
    <a class="btn btn-app" data-toggle="modal" data-target="#modal-default">
        <i style="color:green;" class="fa fa-plus-circle"></i> Criar Tarefa
    </a>
</div>

<!-- MODAL DE CRIAÇÃO DE TAREFAS -->
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Criar nova Tarefa</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="{{ route('criar-tarefa')}}" method="post">
                    {{ csrf_field() }}

                    <div class="card-body">
                        <div class="form-group">
                            <label for="inputName">Título</label>
                            <input type="text" id="inputName" name="nome" class="form-control" required></input>
                        </div>
                        <div class="form-group">
                            <label for="inputName">Descrição</label>
                            <textarea type="text" id="descricao" name="descricao" class="form-control"></textarea>
                        </div>

                        <div>
                            <label for="inputName">Responsável</label>
                            <select class="form-control" id="responsavel" name="responsavel_id" required>
                                <option id="responsavelSelecionado" value="" disabled selected>Selecione o responsável pela tarefa</option>
                                @foreach($colaboradores as $colaborador)
                                <option value='{{$colaborador->id}}'>{{$colaborador->login}}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <input type="hidden" name="status" value="TODO">
                        <input type="hidden" name="us_id" value="{{$id}}">

                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                        <input type="submit" value="Criar" class="btn btn-success float-right">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- fim modal -->

<!-- MODAL DE EDIÇÃO DE TAREFAS -->
<div class="modal fade" id="modal-editar-tarefa">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Editar Tarefa</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form id="form-editar-tarefa" action="" method="post">
                    {{ csrf_field() }}

                    <div class="card-body">
                        <div class="form-group">
                            <label for="inputName">Título</label>
                            <input type="text" id="editarNome" name="nome" class="form-control" required></input>
                        </div>
                        <div class="form-group">
                            <label for="inputName">Descrição</label>
                            <textarea type="text" id="editarDescricao" name="descricao" class="form-control"></textarea>
                        </div>

                        <div>
                            <label for="inputName">Responsável</label>
                            <select class="form-control" id="editarSelectResponsavel" name="responsavel_id" required>

                            </select>
                        </div>

                        <input type="hidden" id="editarIdTarefa" name="idTarefa" value="">

                        <input type="hidden" name="us_id" value="{{$id}}">

                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                        <input type="submit" value="Atualizar" class="btn btn-success float-right">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- fim modal -->


<!-- danger modal -->
<div class="modal fade" id="modal-danger">
    <div class="modal-dialog">
        <div class="modal-content bg-danger">
            <div class="modal-header">
                <h4 class="modal-title">Atenção</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Você tem certeza que deseja excluir a tarefa?</p>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cancelar</button>
                <a class="btn btn-outline-light" id="confirmarExclusao">Confirmar</a>
            </div>
        </div>
    </div>
</div>
<!-- /.modal -->

<div class="col s12">
    <!-- @foreach($tarefas as $indexKey => $tarefa)
    <p>{{$tarefa->descricao}}</p>
    @endforeach -->
    <div id="kanban-tarefas"></div>
</div>
<script>
    var KanbanTest = new jKanban({
        element: "#kanban-tarefas",
        gutter: "3px",
        widthBoard: "320px",
        responsivePercentage: true,
        dragBoards: false,
        itemHandleOptions: {
            enabled: false,
        },

        dropEl: function(el, target, source, sibling) {
            //ajax
            $.get('{!!route("atualizar-s")!!}/' + el.id + '/' + el.parentElement.parentElement.dataset.id);
            console.log(el.id);
            console.log(el.parentElement.parentElement.dataset.id);
        },

        boards: [{
                id: "TODO",
                title: "Tarefas",
                class: "info,good",
                dragTo: ["WORKING"],
                //personalização do item do kanban
                item: []
            },

            {
                id: "WORKING",
                title: "Em execução",
                class: "warning",
                item: []
            },

            {
                id: "DONE",
                title: "Finalizadas",
                class: "success",
                dragTo: ["WORKING"],
                item: []
            },
        ]

    });

    obj = JSON.parse('{!!$tarefas!!}');
    for (const key in obj) {

        if (obj[key].status === 'TODO') {
            var raia = document.getElementsByClassName("kanban-drag")[0];
        } else if (obj[key].status === 'WORKING') {
            var raia = document.getElementsByClassName("kanban-drag")[1];
        } else {
            var raia = document.getElementsByClassName("kanban-drag")[2];
        }

        item = document.createElement('div');
        item.classList.add('kanban-item');
        item.id = obj[key].id;
        item.classList.add('card');
        item.classList.add('card-danger');
        raia.appendChild(item);
        item = document.getElementById(obj[key].id);
        console.log(obj[key].id);
        item.innerHTML =
            '<div class="card-header"  id="tarefa-' + obj[key].id + '" ondblclick="editarTarefa(id)">' +
            '<div class="card-tools">' +
            '<a class="btn btn-tool" id="' + obj[key].id + '" data-target="#modal-danger" onclick="deletarTarefa(event)"data-toggle="modal" title="Deletar tarefa"><i class="fa fa-trash"></i></a>' +
            '<button type="button" class="btn btn-tool" title="Colapsar tarefa" data-card-widget="collapse"><i class="fas fa-minus"></i></button>' +
            "</div>" +
            "</div>" +
            '<div class="card-body">' +
            obj[key].nome +
            "</div>" +
            "</div>";
    }

    function editarTarefa(id) {
        console.log(id);
        const idTarefa = id.substr(-1);

        $.ajax({
            url: '{!!route("editar-tarefa-ajax")!!}/' + idTarefa,
            method: 'GET',
        }).done(function(data, textStatus, jqXHR) {
            console.log(data);
            // console.log(jqXHR.responseText);
            console.log(data.id);
            $("#editarNome").val(data[0].nome);
            $("#editarDescricao").val(data[0].descricao);
            idResponsavelTarefa = (data[0].responsavel_id);
            nomeResponsavelTarefa = (data[1].name);
            $("#editarIdTarefa").val(idTarefa);

            // select = document.querySelector("#editarResponsavel");
            select = document.getElementById("editarSelectResponsavel");
            console.log(select);

            colaboradores = JSON.parse('{!! json_encode($colaboradores)!!}');
            console.log(colaboradores);

            opcoes = "";

            for (const key in colaboradores) {
                console.log(colaboradores[key].id);
                if (colaboradores[key].id != idResponsavelTarefa) {
                    opcoes = opcoes + '<option value="' + colaboradores[key].id + '">' + colaboradores[key].login + '</option>';
                } else {
                    opcoes = opcoes + '<option value="' + idResponsavelTarefa + '" disabled selected>' + nomeResponsavelTarefa + '</option>';
                }
            }

            select.innerHTML = opcoes;

            $("#form-editar-tarefa").attr("action", '{!!route("atualizar-tarefa-ajax")!!}/' + idTarefa);

            $("#modal-editar-tarefa").modal({
                show: true
            });
        });

        // $("#modal-default").modal({
        //     show: true
        // });

    }


    function deletarTarefa(event) {
        //OBS: NÃO ESQUECER DE MUDAR O HREF PARA EXCLUIR A TAREFA!!!!
        console.log(event.target.parentElement.id);
        sessionStorage.setItem('idTarefa', event.target.parentElement.id);
        var idTarefa = sessionStorage.getItem('idTarefa');
        var remove = document.getElementById("confirmarExclusao");
        remove.setAttribute("href", '{!!route("deletar-t")!!}/' + idTarefa + "");
        console.log(idTarefa);
    }
</script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>