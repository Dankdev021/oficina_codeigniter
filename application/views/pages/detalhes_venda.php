<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes da Venda</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        .details-header {
            margin-bottom: 20px;
        }
        .details-section {
            margin-bottom: 20px;
        }
        .total-price {
            font-size: 1.5em;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="main-header details-header">
            <h1>Detalhes da Venda</h1>
        </div>

        <div class="details-section">
            <h2>Informações da Venda</h2>
            <table class="table table-dark table-hover">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Data da Venda</th>
                        <th>Horário da Venda</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($venda)): ?>
                        <tr>
                            <td><?= $venda[0]->cliente_nome; ?></td>
                            <td><?= date('d/m/Y', strtotime($venda[0]->data_venda)); ?></td>
                            <td><?= date('H:i:s', strtotime($venda[0]->data_venda)); ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Itens Vendidos -->
        <div class="details-section">
            <h2>Itens Vendidos</h2>
            <table class="table table-dark table-hover">
                <thead>
                    <tr>
                        <th>Material</th>
                        <th>Quantidade</th>
                        <th>Preço Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($venda as $item): ?>
                    <tr>
                        <td><?= $item->material_nome; ?></td>
                        <td><?= $item->quantidade; ?></td>
                        <td><?= 'R$ ' . number_format($item->preco_total, 2, ',', '.'); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Informações do Vendedor -->
        <div class="details-section">
            <h2>Informações do Vendedor</h2>
            <table class="table table-dark table-hover">
                <thead>
                    <tr>
                        <th>Nome do Vendedor</th>
                        <th>Email</th>
                        <th>CPF</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($vendedor)): ?>
                        <tr>
                            <td><?= $vendedor->nome; ?></td>
                            <td><?= $vendedor->email; ?></td>
                            <td><?= $vendedor->cpf; ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Preço Total da Venda -->
        <div class="details-section">
            <p class="total-price">Preço Total da Venda: <?= 'R$ ' . number_format(array_sum(array_column($venda, 'preco_total')), 2, ',', '.'); ?></p>
        </div>

        <a href="<?= base_url('index.php/VendasController'); ?>" class="btn btn-primary">Voltar</a>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const filePath = urlParams.get('file_path');
            if (filePath) {
                const link = document.createElement('a');
                link.href = "<?= base_url('downloads/'); ?>" + filePath.split('/').pop();
                link.download = filePath.split('/').pop();
                link.click();
            }
        });
    </script>
</body>
</html>
