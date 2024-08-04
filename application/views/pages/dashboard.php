<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .card {
            margin: 20px;
        }
        .card-header {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="main-header">
            <h1>Dashboard</h1>
        </div>
        <div class="row">
            <!-- Card para Usuário Normal -->
            <?php if ($this->session->userdata('user_role') == 'usuario'): ?>
                <div class="col-md-4">
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-header">Informações do Vendedor</div>
                        <div class="card-body">
                            <h5 class="card-title"><?= $vendedor->nome; ?></h5>
                            <p class="card-text"><strong>Email:</strong> <?= $vendedor->email; ?></p>
                            <p class="card-text"><strong>CPF:</strong> <?= $vendedor->cpf; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card text-white bg-secondary mb-3">
                        <div class="card-header">Últimas Vendas</div>
                        <div class="card-body">
                            <table class="table table-dark table-hover">
                                <thead>
                                    <tr>
                                        <th>Cliente</th>
                                        <th>Preço Total</th>
                                        <th>Data da Venda</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($vendas as $venda): ?>
                                    <tr>
                                        <td><?= $venda->cliente_nome; ?></td>
                                        <td><?= 'R$ ' . number_format($venda->preco_total, 2, ',', '.'); ?></td>
                                        <td><?= $venda->data_venda; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Card para Admin -->
            <?php if ($this->session->userdata('user_role') == 'admin'): ?>
                <div class="col-md-6">
                    <div class="card text-white bg-info mb-3">
                        <div class="card-header">Materiais em Estoque</div>
                        <div class="card-body">
                            <table class="table table-dark table-hover">
                                <thead>
                                    <tr>
                                        <th>Material</th>
                                        <th>Quantidade</th>
                                        <th>Preço</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($materiais as $material): ?>
                                    <tr>
                                        <td><?= $material->nome; ?></td>
                                        <td><?= $material->quantidade; ?></td>
                                        <td><?= 'R$ ' . number_format($material->preco, 2, ',', '.'); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-header">Últimas Vendas</div>
                        <div class="card-body">
                            <table class="table table-dark table-hover">
                                <thead>
                                    <tr>
                                        <th>Cliente</th>
                                        <th>Preço Total</th>
                                        <th>Data da Venda</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($vendas as $venda): ?>
                                    <tr>
                                        <td><?= $venda->cliente_nome; ?></td>
                                        <td><?= 'R$ ' . number_format($venda->preco_total, 2, ',', '.'); ?></td>
                                        <td><?= $venda->data_venda; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card text-white bg-warning mb-3">
                        <div class="card-header">Serviços Realizados</div>
                        <div class="card-body">
                            <table class="table table-dark table-hover">
                                <thead>
                                    <tr>
                                        <th>Serviço</th>
                                        <th>Cliente</th>
                                        <th>Data</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($servicos as $servico): ?>
                                    <tr>
                                        <td><?= $servico->descricao; ?></td>
                                        <td><?= $servico->cliente_nome; ?></td>
                                        <td><?= $servico->data_servico; ?></td>
                                        <td><?= $servico->status; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card text-white bg-danger mb-3">
                        <div class="card-header">Gráfico de Vendas</div>
                        <div class="card-body">
                            <canvas id="salesChart"></canvas>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            <?php if ($this->session->userdata('user_role') == 'admin'): ?>
                var ctx = document.getElementById('salesChart').getContext('2d');
                var salesChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: <?= json_encode($sales_chart_labels); ?>,
                        datasets: [{
                            label: 'Vendas',
                            data: <?= json_encode($sales_chart_data); ?>,
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1,
                            fill: false
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            x: {
                                display: true,
                                title: {
                                    display: true,
                                    text: 'Data'
                                }
                            },
                            y: {
                                display: true,
                                title: {
                                    display: true,
                                    text: 'Valor'
                                }
                            }
                        }
                    }
                });
            <?php endif; ?>
        });
    </script>
</body>
</html>
