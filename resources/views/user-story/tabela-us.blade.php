<div class="card">
    <div class="card-header">
        <h3 class="card-title">Requisitos</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th style="width: 10px">#ID</th>
                    <th>História de Usuário</th>
                    <th>Estimativa</th>
                    <th>Prioridade</th>
                    <th>Status</th>
                    <th style="text-align: center;">Tarefas</th>
                    <th style="text-align: center;">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($registros as $registro)
                <tr>
                    <td> <a href="{{ route('kanban-us', $registro->id) }}">{{$registro->id}}</a> </td>
                    <td>{{$registro->descricao}}</td>
                    <td>{{$registro->pontuacao == null ? 'Indefinido' : $registro->pontuacao}} h</td>
                    @isset ($registro->prioridade)
                    @if($registro->prioridade == 'alta')
                    <td>Alta</td>
                    @elseif($registro->prioridade == 'media')
                    <td>Média</td>
                    @else
                    <td>Baixa</td>
                    @endif
                    @endisset
                    <td>{{$registro->status == null ? 'Indefinido' : $registro->status}}</td>
                    <td align="center">
                        <a class="btn" title="Ir para quadro de tarefas" href="{{ route('kanban-us', $registro->id) }}">
                            <i class="fas fa-tasks"></i>
                        </a>
                    </td>
                    <td align="center">
                        <a class="btn" title="Editar dados do registro" href="{{route('editar-us',$registro->id)}}">
                            <i class="fa fa-edit"></i>
                        </a>

                        <a class="btn" title="Clicando aqui, o registro será excluido" href="{{route('deletar-us',$registro->id)}}">
                            <i class="fa fa-trash"></i>
                        </a>


                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

</div>
<!-- /.card -->
<div class="col-12">
    <a href="{{route('voltar-painel')}}" class="btn btn-secondary">Voltar</a>
</div>