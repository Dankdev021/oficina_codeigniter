<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="shortcut icon" href="<?= base_url('application/views/assets/images/favicon.png'); ?>" type="image/x-icon">
    <style>
        .container-fluid {
            padding-left: 0;
        }
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
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .form-container form {
            width: 100%;
            max-width: 400px;
        }
        .form-group label {
            font-weight: bold;
        }
        .btn-primary {
            background-color: #4169E1;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0000FF;
        }
        .gif-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .gif-container img {
            width: 50px;
            height: auto;
        }
        #alertMessage {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row no-gutters">
            <!-- Carrossel -->
            <div class="col-md-8 carousel-container">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="<?= base_url('application/views/assets/images/carrossel1.jpg'); ?>" class="d-block w-100" alt="Imagem 1">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= base_url('application/views/assets/images/carrossel2.jpg'); ?>" class="d-block w-100" alt="Imagem 2">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= base_url('application/views/assets/images/oficina4.webp'); ?>" class="d-block w-100" alt="Imagem 3">
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
            <div class="col-md-4 form-container">
                <div class="gif-container">
                    <img src="<?= base_url('/application/views/assets/images/engine.webp'); ?>" alt="Engrenagens Girando">
                </div>
                <form id="loginForm">
                    <div class="form-group">
                        <label for="nome">Nome de Usuário</label>
                        <input type="text" name="nome" class="form-control" id="nome" placeholder="Daniel Sousa" required>
                    </div>
                    <div class="form-group">
                        <label for="senha">Senha</label>
                        <input type="password" name="senha" class="form-control" id="senha" placeholder="••••••••••••" required>
                    </div>
                    <div class="form-group">
                        <label for="role">Acessar como:</label>
                        <select name="role" class="form-control" id="role" required>
                            <option value="usuario">Usuário</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="form-group text-right">
                        <a href="#">Esqueceu a sua senha?</a>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">ENTRAR</button>
                </form>
                <div id="alertMessage" class="alert alert-danger mt-3"></div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#loginForm').on('submit', function(e){
                e.preventDefault();
                $('#alertMessage').hide().removeClass('alert-success alert-danger');

                $.ajax({
                    url: '<?= base_url('index.php/LoginController/authenticate'); ?>',
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response){
                        console.log(response); // Log para depuração
                        if(response.success){
                            window.location.href = '<?= base_url('index.php/DashboardController/index'); ?>';
                        } else {
                            $('#alertMessage').text(response.message).show().addClass('alert-danger');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown){
                        console.log("Erro: " + textStatus + " " + errorThrown); // Log para depuração
                        $('#alertMessage').text('Ocorreu um erro ao tentar fazer login. Tente novamente.').show().addClass('alert-danger');
                    }
                });
            });
        });
    </script>
</body>
</html>
