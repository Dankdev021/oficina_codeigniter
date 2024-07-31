<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .carousel-container {
            height: 100vh;
            padding: 0;
        }
        .carousel-item img {
            height: 100vh;
            width: 100%;
            object-fit: cover;
        }
        .form-container {
            height: 100vh;
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .form-container form {
            width: 80%;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row no-gutters">
            <!-- Carrossel -->
            <div class="col-md-6 carousel-container">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="/oficina_codeigniter/application/views/assets/images/carrossel1.jpg" class="d-block w-100" alt="Imagem 1">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>Primeira Imagem</h5>
                                <p>Descrição da primeira imagem.</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="/oficina_codeigniter/application/views/assets/images/carrossel2.jpg" class="d-block w-100" alt="Imagem 2">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>Segunda Imagem</h5>
                                <p>Descrição da segunda imagem.</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="/oficina_codeigniter/application/views/assets/images/carrossel3.jpg" class="d-block w-100" alt="Imagem 3">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>Terceira Imagem</h5>
                                <p>Descrição da terceira imagem.</p>
                            </div>
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            <!-- Formulário -->
            <div class="col-md-6 form-container">
                <form>
                    <h2 class="mb-4">Formulário de Contato</h2>
                    <div class="form-group">
                        <label for="nome">Nome</label>
                        <input type="text" class="form-control" id="nome" placeholder="Digite seu nome">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="Digite seu email">
                    </div>
                    <div class="form-group">
                        <label for="mensagem">Mensagem</label>
                        <textarea class="form-control" id="mensagem" rows="4" placeholder="Digite sua mensagem"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
