<?php
?>

<?php
?>

<h1> Depoimentos </h1>
<p>Depimentos enviador por usuários</p>
<hr>
<a href="{{URL}}/admin/testimonies/new">
    <button type="button" class="btn btn-success">Cadastrar depoimento</button>
</a>
<hr>

{{status}}

<table class="table table-light table-striped">
    <thead>
    <tr>
        <th>ID</th>
        <th style="width: 200px">Nome</th>
        <th>Mensagem</th>
        <th>Data</th>
        <th style="width: 200px">Ações</th>
    </tr>
    </thead>

    <tbody>
    {{itens}}
    </tbody>
</table>

{{pagination}}

