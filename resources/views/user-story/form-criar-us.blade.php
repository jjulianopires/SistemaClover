<form action="{{ route('criar-us')}}" method="post">
    {{ csrf_field() }}

    <div class="card-body">

        <div class="form-group" style="padding: 20px;">
            <label for="inputName">Descrição</label>
            <textarea type="text" id="inputName" name="descricao" class="form-control" placeholder="ex: Como... Eu quero... A fim de..." required></textarea>
        </div>
        <div class="form-group" style="padding: 20px;">
            <label for="inputDescription">Tempo estimado para conclusão em horas</label>
            <input style="width: 10%;" type="number" min="0" max="100" id="inputDescription" placeholder="ex: 10" name="pontuacao" class="form-control" required>
            <!-- <label style="position: absolute; left: 14%;top: 50%; width: 10%;">H</label> -->
            </input>
        </div>

        <div class="form-group" style="width: 20%; padding: 20px;">
            <label for="inputStatus">Prioridade</label>
            <select name="prioridade" id="prioridade" class="form-control custom-select" required>
                <option value="" selected disabled>Selecione</option>
                <option value="alta">Alta</option>
                <option value="media">Média</option>
                <option value="baixa">Baixa</option>
            </select>
        </div>
    </div>

    <!-- /.card -->
    <div class="col-12">
        <a href="{{route('voltar-painel')}}" class="btn btn-secondary">Voltar</a>
        <input type="submit" value="Adicionar" class="btn btn-success float-right">
    </div>

</form>