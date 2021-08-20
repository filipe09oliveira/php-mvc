<div class="d-flex justify-content-center">
    <div class="card mt-3 text-dark text-center" style="width: 550px;">
        <div class="card-header">
            <h1>LOGIN</h1>
        </div>
        <div class="card-body">
            {{status}}
            <form method="POST">
                <div class="form-group">
                    <label>E-mail:</label>
                    <input type="email" name="email" class="form-control" placeholder="email@teste.com" required autofocus>
                </div>
                <div class="form-group my-3">
                    <label>Senha:</label>
                    <input type="password" name="senha" class="form-control" placeholder="************" required>
                </div>
                <button type="submit" class="btn btn-lg btn-danger">Entrar</button>
            </form>
        </div>
    </div>
</div>