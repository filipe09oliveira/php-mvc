<!--<div class="jumbotron bg-danger p-3 my-3">-->
<!--    <h1>WDEV - MVC</h1>-->
<!--    <P>Model - View - Controller</p>-->
<!--    <a href="{{URL}}"><button class="btn btn-light">Home</button></a>-->
<!--    <a href="{{URL}}/sobre"><button class="btn btn-light">Sobre</button></a>-->
<!--    <a href="{{URL}}/depoimentos"><button class="btn btn-light">Depoimentos</button></a>-->
<!--</div>-->

<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{URL}}">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{URL}}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{URL}}/sobre">Sobre</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{URL}}/depoimentos">Depoimentos</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{URL}}/devedores">Devedores</a>
                </li>
            </ul>
            <form class="d-flex">
                <a class="btn btn-success" href="#">Cadastrar</a>
                <a class="btn btn-outline-warning" href="#" style="margin-left: 10px">Entrar</a>
            </form>
        </div>
    </div>
</nav>