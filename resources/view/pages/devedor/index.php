<div class="container" style="margin-top: 30px;">
    <a class="btn btn-primary" href="{{URL}}/devedor" role="button">Adicionar</a>

    <div class="card text-dark" style="margin-top: 10px">
        <div class="card-header">
            Devedores
        </div>
        <div class="card-body">
            <table id="example" class="table table-striped" style="width:100%">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>CPF/CNPJ</th>
                    <th>Data Nascimento</th>
                    <th>Titulo</th>
                    <th>Valor</th>
                </tr>
                </thead>
                <tbody>

                {{itens}}

                </tbody>
                <tfoot>
                <tr>
                    <th>Nome</th>
                    <th>CPF/CNPJ</th>
                    <th>Data Nascimento</th>
                    <th>Titulo</th>
                    <th>Valor</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
