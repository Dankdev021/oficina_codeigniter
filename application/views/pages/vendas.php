<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        .form-container {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .item-row {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .item-row select, .item-row input {
            margin-right: 10px;
        }
        .item-row button {
            background-color: #ff0000;
            border: none;
            color: white;
            padding: 5px 10px;
            cursor: pointer;
        }
        .error-message {
            color: red;
            display: none;
        }
        .pagination {
            justify-content: center;
        }
        .pagination .page-item .page-link {
            color: #007bff;
        }
        #vendaModal {
            padding: 15px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="main-header">
            <h1>Vendas Realizadas</h1>
        </div>
        
        <!-- Listagem de Vendas -->
        <table class="table table-dark table-hover mt-5">
            <button class="btn btn-primary mt-5" data-toggle="modal" data-target="#vendaModal">Registrar Venda</button>

            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Preço Total</th>
                    <th>Data da Venda</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody id="vendasTableBody">
                <?php foreach ($vendas as $venda): ?>
                <tr>
                    <td><?= $venda->cliente_nome; ?></td>
                    <td><?= 'R$ ' . number_format($venda->preco_total, 2, ',', '.'); ?></td>
                    <td><?= $venda->data_venda; ?></td>
                    <td>
                        <a href="<?= base_url('index.php/VendasController/detalhes/'.$venda->id); ?>" class="btn btn-info">Detalhes</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <nav>
            <ul class="pagination">
                <li class="page-item disabled" id="prevPage">
                    <a class="page-link" href="#" aria-label="Previous" data-page="prev">
                        <span aria-hidden="true"><i class="fa-solid fa-arrow-left"></i></span>
                    </a>
                </li>
                <!-- Dynamic pagination items will be added here by JavaScript -->
                <li class="page-item" id="nextPage">
                    <a class="page-link" href="#" aria-label="Next" data-page="next">
                        <span aria-hidden="true"><i class="fa-solid fa-arrow-right"></i></span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="vendaModal" tabindex="-1" aria-labelledby="vendaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="vendaModalLabel">Registrar Venda</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="vendaForm" action="<?= base_url('index.php/VendasController/create'); ?>" method="post" onsubmit="return validateForm()">
                        <div class="form-group">
                            <label for="cliente_nome">Nome do Cliente</label>
                            <input type="text" name="cliente_nome" class="form-control" id="cliente_nome" required>
                        </div>
                        <div id="itensContainer">
                            <div class="item-row">
                                <select name="itens_venda[0][material_id]" class="form-control" required onchange="updatePrice(this)">
                                    <option value="" disabled selected>Selecione o Material</option>
                                    <?php foreach ($materiais as $material): ?>
                                    <option value="<?= $material->id; ?>" data-price="<?= $material->preco; ?>"><?= $material->nome; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <input type="number" name="itens_venda[0][quantidade]" class="form-control" placeholder="Quantidade" required onchange="updatePrice(this)" min="1">
                                <input type="hidden" name="itens_venda[0][preco_total]" class="item-price">
                                <button type="button" onclick="removeItem(this)">Remover</button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary" onclick="addItem()">Adicionar Item</button>
                        <div class="form-group mt-3">
                            <label for="total_price">Preço Total</label>
                            <input type="hidden" name="preco_total" id="total_price_input">
                            <input type="text" id="total_price" class="form-control" readonly>
                        </div>
                        <div class="error-message" id="errorMessage">Por favor, verifique os itens. Quantidade e preço não podem ser zero.</div>
                        <button type="submit" class="btn btn-primary">Registrar Venda</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){
            // Adicionar funcionalidade de paginação
            const rowsPerPage = 8;
            const rows = $('#vendasTableBody tr');
            const rowsCount = rows.length;
            const pageCount = Math.ceil(rowsCount / rowsPerPage); // Calculate total number of pages
            const pagination = $('.pagination');

            let currentPage = 1;

            // Create pagination links
            for (let i = 1; i <= pageCount; i++) {
                $('<li class="page-item"><a class="page-link" href="#" data-page="' + i + '">' + i + '</a></li>').insertBefore('#nextPage');
            }

            // Display first set of rows
            displayRows(currentPage);

            // Add click event to pagination links
            $('.pagination').on('click', 'a', function(e) {
                e.preventDefault();
                const page = $(this).data('page');
                if (page === 'next') {
                    if (currentPage < pageCount) {
                        currentPage++;
                        displayRows(currentPage);
                    }
                } else if (page === 'prev') {
                    if (currentPage > 1) {
                        currentPage--;
                        displayRows(currentPage);
                    }
                } else {
                    currentPage = page;
                    displayRows(currentPage);
                }
            });

            function displayRows(page) {
                const start = (page - 1) * rowsPerPage;
                const end = start + rowsPerPage;
                rows.hide();
                rows.slice(start, end).show();

                // Update pagination active state
                $('.pagination .page-item').removeClass('active');
                $('.pagination .page-item').eq(page).addClass('active');

                // Disable previous/next buttons at the limits
                $('#prevPage').toggleClass('disabled', page === 1);
                $('#nextPage').toggleClass('disabled', page === pageCount);
            }

            // Search functionality
            $('#searchInput').on('keyup', function(){
                const value = $(this).val().toLowerCase();
                $('#vendasTableBody tr').filter(function(){
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
        });

        function addItem() {
            var itemCount = $('#itensContainer .item-row').length;
            var newItem = `
                <div class="item-row">
                    <select name="itens_venda[${itemCount}][material_id]" class="form-control" required onchange="updatePrice(this)">
                        <option value="" disabled selected>Selecione o Material</option>
                        <?php foreach ($materiais as $material): ?>
                        <option value="<?= $material->id; ?>" data-price="<?= $material->preco; ?>"><?= $material->nome; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="number" name="itens_venda[${itemCount}][quantidade]" class="form-control" placeholder="Quantidade" required onchange="updatePrice(this)" min="1">
                    <input type="hidden" name="itens_venda[${itemCount}][preco_total]" class="item-price">
                    <button type="button" onclick="removeItem(this)">Remover</button>
                </div>
            `;
            $('#itensContainer').append(newItem);
        }

        function removeItem(button) {
            $(button).closest('.item-row').remove();
            updateTotalPrice();
        }

        function updatePrice(element) {
            var row = $(element).closest('.item-row');
            var price = parseFloat(row.find('select option:selected').data('price'));
            var quantity = parseFloat(row.find('input[type="number"]').val());
            if (!isNaN(price) && !isNaN(quantity) && quantity > 0) {
                var total = price * quantity;
                row.find('.item-price').val(total);
                updateTotalPrice();
            }
        }

        function updateTotalPrice() {
            var totalPrice = 0;
            $('.item-price').each(function() {
                totalPrice += parseFloat($(this).val()) || 0;
            });
            $('#total_price').val('R$ ' + totalPrice.toFixed(2).replace('.', ','));
            $('#total_price_input').val(totalPrice.toFixed(2));
        }

        function validateForm() {
            var isValid = true;
            $('#errorMessage').hide();
            $('.item-row').each(function() {
                var quantity = $(this).find('input[type="number"]').val();
                var price = $(this).find('.item-price').val();
                if (quantity <= 0 || price <= 0) {
                    isValid = false;
                }
            });
            if (!isValid) {
                $('#errorMessage').show();
            }
            return isValid;
        }
    </script>
</body>
</html>
