<?php
?>

<h1> {{title}} </h1>
<hr>
<a href="{{URL}}/admin/testimonies">
    <button type="button" class="btn btn-warning">Voltar</button>
</a>

<hr>

{{status}}
<form method="post">
    <div class="form-group">
        <label>Nome</label>
        <input class="form-control" type="text" name="nome" id="nome" value="{{nome}}" required>
    </div>

    <div class="form-group my-3">
        <label>Mensagem</label>
        <textarea class="form-control" name="mensagem" id="mensagem" rows="5" required>{{mensagem}}</textarea>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-success"> Enviar </button>
    </div>
</form>