<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mecanit</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="shortcut icon" href="<?= base_url('application/views/assets/images/favicon.png'); ?>" type="image/x-icon">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #333;
            color: #FFF;
        }
        .sidebar {
            height: 100vh;
            background-color: #4169E1;
            padding-top: 20px;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            overflow-x: hidden;
            overflow-y: auto;
        }
        .sidebar a {
            padding: 20px;
            text-align: center; 
            display: flex; 
            flex-direction: column; 
            align-items: center; 
            color: #FFF;
            text-decoration: none; 
            font-size: 16px;
        }
        .sidebar a:visited, .sidebar a:hover, .sidebar a:focus, .sidebar a:active {
            color: #FFF;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #0000FF;
        }
        .sidebar a i {
            font-size: 24px;
            margin-bottom: 5px;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        .main-header {
            background-color: #222;
            padding: 20px;
            position: fixed;
            width: calc(100% - 250px);
            top: 0;
            left: 250px;
            z-index: 1000;
        }
        .main-header h1 {
            margin: 0;
        }
        .content {
            margin-top: 70px;
        }
        .spinner-overlay {
            display: flex;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            align-items: center;
            justify-content: center;
        }
        .spinner {
            border: 16px solid #f3f3f3;
            border-top: 16px solid #3498db;
            border-radius: 50%;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div id="loadingSpinner" class="spinner-overlay">
        <div class="spinner"></div>
    </div>
    <div class="sidebar">
        <a href="<?= base_url('index.php/DashboardController/index'); ?>"><i class="fa-solid fa-chart-line"></i><span>Dashboard</span></a>
        <a href="<?= base_url('index.php/VendasController/index'); ?>"><i class="fa-solid fa-shopping-cart"></i><span>Vendas</span></a>
        <a href="<?= base_url('index.php/CatalogoController/index'); ?>"><i class="fa-solid fa-box"></i><span>Estoque</span></a>
        <?php if ($this->session->userdata('user_role') == 'admin'): ?>
            <a href="<?= base_url('index.php/UsuariosController/index'); ?>"><i class="fa-solid fa-users"></i><span>Usuários</span></a>
        <?php endif; ?>
        <a href="<?= base_url('index.php/ServicosController/index'); ?>"><i class="fa-solid fa-gear"></i></i><span>Serviços</span></a>
        <a href="<?= base_url('index.php/RelatoriosController/index'); ?>"><i class="fa-solid fa-chart-bar"></i><span>Relatórios</span></a>
        <a href="<?= base_url('index.php/LoginController/logout'); ?>"><i class="fa-solid fa-sign-out-alt"></i><span>Sair</span></a>
    </div>

    <div class="main-content content">
        <?php $this->load->view($view); ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#loadingSpinner").show();

            $(window).on('load', function() {
                $("#loadingSpinner").fadeOut();
            });

            $(".sidebar a").on('click', function(e) {
                e.preventDefault();
                $("#loadingSpinner").show();
                window.location.href = $(this).attr('href');
            });
        });
    </script>
</body>
</html>
