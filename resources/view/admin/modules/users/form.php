<?php
?>

<h1> {{title}} </h1>
<hr>
<a href="{{URL}}/admin/users">
    <button type="button" class="btn btn-warning">Voltar</button>
</a>

<hr>

{{status}}
<form method="post">
    <div class="form-group mt-3">
        <label>Nome</label>
        <input class="form-control" type="text" name="nome" id="nome" value="{{nome}}" required>
    </div>

    <div class="form-group mt-3">
        <label>E-mail</label>
        <input class="form-control" type="email" name="email" id="email" value="{{email}}" required>
    </div>

    <div class="form-group mt-3">
        <label>Senha</label>
        <input class="form-control" type="password" name="senha" id="senha" required>
    </div>

    <div class="form-group mt-3">
        <button type="submit" class="btn btn-success"> Enviar </button>
    </div>
</form>