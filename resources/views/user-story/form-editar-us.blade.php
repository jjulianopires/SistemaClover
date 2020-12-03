@extends('adminlte::page')

@section('content')
<div class="col-md-12">
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
            sessionStorage.setItem("success", " ");
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
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Projeto - {{$nomeProjeto}}</h3>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header p-3 col-12">
                    <form action="{{ route('atualizar-us', $registro->id)}}" method="post">
                        {{ csrf_field() }}

                        <div class="card-body">

                            <!-- <a class="btn btn-app" href="{{route('deletar-us',$registro->id)}}">
                                <i class="fa fa-trash"></i> Excluir
                            </a> -->

                            <div class="form-group" style="padding: 20px;">
                                <label for="inputName">Descrição da User Story</label>
                                <textarea type="text" id="inputName" name="descricao" class="form-control" required>{{isset($registro->descricao) ? $registro->descricao : ' '}}</textarea>
                            </div>

                            <div class="form-group" style="padding: 20px;">
                                <label for="inputDescription">Tempo estimado para conclusão da US em horas</label>
                                <input style="width: 10%;" type="number" min="0" max="100" value="{{isset($registro->pontuacao) ? $registro->pontuacao : ' '}}" id="inputDescription" placeholder="ex: 10" name="pontuacao" class="form-control" required>
                                <!-- <label style="position: absolute; left: 14%;top: 50%; width: 10%;">H</label> -->
                                </input>
                            </div>

                            <div class="form-group" style="width: 20%; padding: 20px;">
                                <label for="inputStatus">Prioridade da US</label>
                                <select name="prioridade" id="prioridade" class="form-control custom-select" required>
                                    @if ($registro->prioridade == 'alta')
                                    <option selected value="alta">Alta</option>
                                    <option value="media">Média</option>
                                    <option value="baixa">Baixa</option>
                                    @elseif ($registro->prioridade == 'media')
                                    <option value="alta">Alta</option>
                                    <option selected value="media">Média</option>
                                    <option value="baixa">Baixa</option>
                                    @else
                                    <option value="alta">Alta</option>
                                    <option value="media">Média</option>
                                    <option selected value="baixa">Baixa</option>
                                    @endif
                                </select>
                            </div>
                        </div>

                        <!-- /.card -->
                        <div class="col-12">
                            <a href="{{ route('painel-us')}}" class="btn btn-secondary">Cancel</a>
                            <input type="submit" value="Atualizar Dados" class="btn btn-success float-right">
                        </div>

                    </form>
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