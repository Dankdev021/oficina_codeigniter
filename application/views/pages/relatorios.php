<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        .table-container {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="main-header">
            <h1>Relatórios</h1>
        </div>
        <?php if ($this->session->flashdata('relatorio_sucesso')): ?>
        <div id="alertSuccess" class="alert alert-success" role="alert">
            <?= $this->session->flashdata('relatorio_sucesso'); ?>
        </div>
        <?php endif; ?>
        <div class="form-container">
            <form id="relatorioForm" action="<?= base_url('index.php/RelatoriosController/gerar_relatorio'); ?>" method="post" onsubmit="showAlert()">
                <div class="form-group">
                    <label for="tipo_relatorio">Tipo de Relatório</label>
                    <select name="tipo_relatorio" class="form-control" id="tipo_relatorio" required>
                        <option value="vendas">Vendas</option>
                        <option value="catalogo">Catálogo</option>
                        <option value="servicos">Serviços</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="data_inicio">Data de Início</label>
                    <input type="date" name="data_inicio" class="form-control" id="data_inicio" required>
                </div>
                <div class="form-group">
                    <label for="data_fim">Data de Fim</label>
                    <input type="date" name="data_fim" class="form-control" id="data_fim" required>
                </div>
                <button type="submit" class="btn btn-primary">Gerar Relatório</button>
            </form>
        </div>
    </div>

    <script>
        function showAlert() {
            document.getElementById('alertSuccess').style.display = 'block';
        }

        $(document).ready(function() {
            setTimeout(function() {
                $('#alertSuccess').fadeOut('slow');
            }, 3000); // 3000 milliseconds = 3 seconds

            // Remove flashdata on page load
            if (window.performance && window.performance.navigation.type === window.performance.navigation.TYPE_RELOAD) {
                $('#alertSuccess').remove();
            }
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
