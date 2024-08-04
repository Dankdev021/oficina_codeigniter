<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serviços</title>
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
            <h1>Serviços</h1>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#serviceModal">
                Cadastrar Serviço
            </button>
        </div>
        <div class="table-container">
            <table class="table table-dark table-hover">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Descrição</th>
                        <th>Valor da Mão de Obra</th>
                        <th>Valor Total</th>
                        <th>Data de Cadastro</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($servicos as $servico): ?>
                    <tr>
                        <td><?= $servico->cliente; ?></td>
                        <td><?= $servico->descricao; ?></td>
                        <td><?= 'R$ ' . number_format($servico->valor_mao_obra, 2, ',', '.'); ?></td>
                        <td><?= 'R$ ' . number_format($servico->valor_total, 2, ',', '.'); ?></td>
                        <td><?= date('d/m/Y', strtotime($servico->created_at)); ?></td>
                        <td>
                            <a href="<?= base_url('index.php/ServicosController/detalhes/'.$servico->id); ?>" class="btn btn-info">Detalhes</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal de Cadastro de Serviço -->
    <div class="modal fade" id="serviceModal" tabindex="-1" aria-labelledby="serviceModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="serviceForm" action="<?= base_url('index.php/ServicosController/create'); ?>" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="serviceModalLabel">Cadastrar Serviço</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="cliente">Nome do Cliente</label>
                            <input type="text" name="cliente" class="form-control" id="cliente" required>
                        </div>
                        <div class="form-group">
                            <label for="descricao">Descrição</label>
                            <textarea name="descricao" class="form-control" id="descricao" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="data_inicio">Data de Início</label>
                            <input type="date" name="data_inicio" class="form-control" id="data_inicio" required>
                        </div>
                        <div class="form-group">
                            <label for="data_conclusao_estimada">Data de Conclusão Estimada</label>
                            <input type="date" name="data_conclusao_estimada" class="form-control" id="data_conclusao_estimada" required>
                        </div>
                        <div class="form-group">
                            <label for="mecanico_id">Mecânico</label>
                            <select name="mecanico_id" class="form-control" id="mecanico_id" required>
                                <?php foreach ($mecanicos as $mecanico): ?>
                                <option value="<?= $mecanico->id; ?>"><?= $mecanico->nome; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="valor_mao_obra">Valor da Mão de Obra</label>
                            <input type="number" name="valor_mao_obra" class="form-control" id="valor_mao_obra" required oninput="updateTotalPrice()">
                        </div>
                        <div class="form-group">
                            <label for="material_select">Materiais</label>
                            <select name="material_select" id="material_select" class="form-control">
                                <option value="" disabled selected>Selecione o Material</option>
                                <?php foreach ($materiais as $material): ?>
                                <option value="<?= $material->id; ?>" data-preco="<?= $material->preco; ?>"><?= $material->nome; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <input type="number" id="material_quantity" class="form-control" placeholder="Quantidade" min="1">
                            <button type="button" class="btn btn-secondary mt-2" onclick="addMaterial()">Adicionar Material</button>
                        </div>
                        <div id="materialList"></div>
                        <input type="hidden" name="valor_total" id="valor_total">
                        <input type="hidden" name="materiais" id="materiais">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Cadastrar Serviço</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let materiais = [];

        function addMaterial() {
            const materialSelect = document.getElementById('material_select');
            const materialQuantityInput = document.getElementById('material_quantity');
            const selectedMaterial = materialSelect.options[materialSelect.selectedIndex];
            const materialId = selectedMaterial.value;
            const materialName = selectedMaterial.text;
            const materialPrice = parseFloat(selectedMaterial.getAttribute('data-preco'));
            const materialQuantity = parseInt(materialQuantityInput.value);

            if (!materialId || isNaN(materialPrice) || isNaN(materialQuantity) || materialQuantity <= 0) {
                alert('Por favor, selecione um material válido e insira uma quantidade válida.');
                return;
            }

            const materialTotal = materialPrice * materialQuantity;
            materiais.push({ id: materialId, name: materialName, quantity: materialQuantity, price: materialTotal });

            const materialList = document.getElementById('materialList');
            const materialItem = document.createElement('div');
            materialItem.classList.add('material-item');
            materialItem.innerHTML = `<p>${materialName} - Quantidade: ${materialQuantity} - Preço Total: R$ ${materialTotal.toFixed(2)}</p>`;
            materialList.appendChild(materialItem);

            updateTotalPrice();
            document.getElementById('materiais').value = JSON.stringify(materiais);
            materialQuantityInput.value = '';
        }

        function updateTotalPrice() {
            const valorMaoObra = parseFloat(document.getElementById('valor_mao_obra').value) || 0;
            const valorMateriais = materiais.reduce((acc, material) => acc + material.price, 0);
            const valorTotal = valorMaoObra + valorMateriais;
            document.getElementById('valor_total').value = valorTotal.toFixed(2);
        }

        document.getElementById('valor_mao_obra').addEventListener('input', updateTotalPrice);
    </script>


    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
