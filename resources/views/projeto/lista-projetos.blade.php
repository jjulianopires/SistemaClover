@extends('adminlte::page')

@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Meus Projetos</h3>
    </div>


    @isset($listaProjetos)
    <!-- /.card-header -->
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th style="width: 10px">#ID</th>
                    <th>Nome do Projeto</th>
                    <th>Colaboradores</th>
                    <th>Última Atualização</th>
                    <th>Tipo</th>
                    <th>Página do Projeto</th>
                    <th style="text-align: center;">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($listaProjetos as $indexKey => $projeto)
                <tr>
                    <td> <a href="{{ route('abrir-projeto', $projeto->id) }}">{{$projeto->id}}</a> </td>
                    <td>{{$projeto->name}}</td>
                    <td>
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                @if(isset($projeto->contribuidores->login))
                                <img alt="Avatar" title="{{$projeto->contribuidores->login}}" id="{{$projeto->contribuidores->id}}" width="30" style="border-radius: 50%" src="{{$projeto->contribuidores->avatar_url}}">
                                @else
                                @foreach($projeto->contribuidores as $contribuidor)
                                <img alt="Avatar" title="{{$contribuidor->login}}" id="{{$contribuidor->id}}" width="30" style="border-radius: 50%" src="{{$contribuidor->avatar_url}}">
                                @endforeach
                                @endif
                            </li>
                        </ul>
                    </td>
                    <td align="center">
                        <a>
                            {{ date("d-m-Y", strtotime($projeto->updated_at))}}
                        </a>
                        <br />
                        <small>
                            {{date("H:i:s", strtotime($projeto->updated_at))}}
                        </small>
                    </td>
                    <td>{{$projeto->private == false ? 'Público' : 'Privado'}}</td>
                    <td align="center">{{$projeto->homepage == null ? 'N/A' : '$projeto->homepage'}}</td>
                    <td align="center">
                        <a class="btn" title="Editar dados do projeto" href="{{route('editar-projeto',$projeto->id)}}">
                            <i class="fa fa-edit"></i>
                        </a>

                        <a class="btn" id="{{$projeto->id}}" title="Clicando aqui, o projeto será excluido" onclick="deletarProjeto(event)" href="{{route('deletar-projeto',$projeto->id)}}">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>

    <script>
        function deletarProjeto(event) {
            var id = event.target.parentElement.id;
            var registro = document.getElementById(id);
            event.preventDefault();
            swal({
                    title: "Tem certeza?",
                    text: "Clicando no botão ok o repositório do projeto será apagado!",
                    icon: "warning",
                    buttons: ["Cancelar", "OK"],
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        document.location.href = registro.href;
                    } else {

                    }
                });
        }
    </script>
    @else
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Faça login com sua conta do github para visualizar seus projetos.</h3>
        </div>
    </div>
    @endisset
</div>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@endsection