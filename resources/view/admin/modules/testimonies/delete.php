<?php
?>

<h1> Excluir depoimento </h1>
<hr>
<a href="{{URL}}/admin/testimonies">
    <button type="button" class="btn btn-warning">Voltar</button>
</a>

<hr>

<form method="post">
    <div class="form-group">
        Você deseja realmente excluir o depoimento de <b>{{nome}}</b>
    </div>

    <div class="form-group mt-3">
        <button type="submit" class="btn btn-danger"> Excluir </button>
    </div>
</form>