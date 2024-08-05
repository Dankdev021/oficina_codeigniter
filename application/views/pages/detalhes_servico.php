<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Serviço</title>
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
            <h1>Detalhes do Serviço</h1>
        </div>
        <div class="table-container">
            <h2>Informações do Serviço</h2>
            <table class="table table-dark table-hover">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Descrição</th>
                        <th>Data de Início</th>
                        <th>Data de Conclusão Estimada</th>
                        <th>Mecânico</th>
                        <th>Valor da Mão de Obra</th>
                        <th>Valor Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= $servico->cliente; ?></td>
                        <td><?= $servico->descricao; ?></td>
                        <td><?= date('d/m/Y', strtotime($servico->data_inicio)); ?></td>
                        <td><?= date('d/m/Y', strtotime($servico->data_conclusao_estimada)); ?></td>
                        <td><?= $mecanico->nome; ?></td>
                        <td><?= 'R$ ' . number_format($servico->valor_mao_obra, 2, ',', '.'); ?></td>
                        <td><?= 'R$ ' . number_format($servico->valor_total, 2, ',', '.'); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="table-container">
            <h2>Materiais Utilizados</h2>
            <table class="table table-dark table-hover">
                <thead>
                    <tr>
                        <th>Material</th>
                        <th>Quantidade</th>
                        <th>Preço Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($materiais as $material): ?>
                    <tr>
                        <td><?= $material->nome; ?></td>
                        <td><?= $material->quantidade; ?></td>
                        <td><?= 'R$ ' . number_format($material->preco_total, 2, ',', '.'); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <a href="<?= base_url('index.php/ServicosController'); ?>" class="btn btn-primary">Voltar</a>
    </div>
</body>
</html>
