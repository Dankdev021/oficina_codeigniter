<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mecanit</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="shortcut icon" href="/oficina_codeigniter/application/views/assets/images/favicon.png" type="image/x-icon">
    <script src="https://kit.fontawesome.com/b8b3f6fe70.js" crossorigin="anonymous"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: #000; /* Preto */
        }
        .navbar-brand, .nav-link {
            color: #FFF; /* Branco */
        }
        .navbar-brand:hover, .nav-link:hover {
            color: #FFD700; /* Amarelo */
        }
        .nav-link.active {
            color: #FF0000; /* Vermelho */
        }
        .nav-item {
            text-align: center; /* Centraliza o texto abaixo do ícone */
            margin-left: 20px; /* Espaçamento entre os ícones */
            margin-right: 20px; /* Espaçamento entre os ícones */
        }
        .nav-item i {
            display: block;
        }

        #iconlogin {
            color: #FFD700;
        }

        #iconlogout {
            color: #FF0000;
        }

        .carousel-container {
            max-width: 400px; /* Define a largura máxima do carrossel */
            margin: 20px auto; /* Centraliza o carrossel e adiciona margem */
        }

    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="#">Mecanit</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <div>
                        <i class="fa-solid fa-right-to-bracket fa-2x" id="iconlogin"></i>
                        <span style="color: #FFD700;">Login</span>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
