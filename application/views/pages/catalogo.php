<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Materiais</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .search-container {
            width: 100%;
            max-width: 400px;
            position: relative;
        }
        .search-container input {
            width: 100%;
            padding: 10px 20px;
            border: 1px solid #ccc;
            border-radius: 25px;
            background-color: #333;
            color: #FFF;
        }
        .search-container input::placeholder {
            color: #ccc;
        }
        .search-container .fa-search {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            color: #007bff;
        }
        .material-table th, .material-table td {
            color: #FFF;
        }
        .btn-primary .fa-plus {
            margin-right: 5px;
            font-size: 1.2em;
        }
        .pagination {
            justify-content: center;
        }
        .pagination .page-item .page-link {
            color: #007bff;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>Catálogo de Materiais</h1>
        
        <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('success'); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php endif; ?>
        
        <div class="top-bar">
            <div class="search-container">
                <input type="text" id="searchInput" placeholder="Pesquisar material..." class="form-control">
                <i class="fa fa-search"></i>
            </div>
            <?php if ($this->session->userdata('user_role') == 'admin'): ?>
                <div>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addMaterialModal">
                        <i class="fa-solid fa-plus"></i> Adicionar Material
                    </button>
                </div>
            <?php endif; ?>
        </div>

        <h2>Materiais Ativos</h2>
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Preço</th>
                    <th>Quantidade</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody id="materialTableBody">
                <?php foreach ($materiais_ativos as $material): ?>
                <tr>
                    <td><?= $material->nome; ?></td>
                    <td><?= 'R$ ' . number_format($material->preco, 2, ',', '.'); ?></td>
                    <td><?= $material->quantidade; ?></td>
                    <td>
                        <a href="<?= base_url('index.php/CatalogoController/inactivate/'.$material->id); ?>" class="btn btn-warning">Inativar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Materiais Inativos</h2>
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Preço</th>
                    <th>Quantidade</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody id="materialTableBodyInactive">
                <?php foreach ($materiais_inativos as $material): ?>
                <tr>
                    <td><?= $material->nome; ?></td>
                    <td><?= 'R$ ' . number_format($material->preco, 2, ',', '.'); ?></td>
                    <td><?= $material->quantidade; ?></td>
                    <td>
                        <a href="<?= base_url('index.php/CatalogoController/activate/'.$material->id); ?>" class="btn btn-success">Ativar</a>
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
                <li class="page-item" id="nextPage">
                    <a class="page-link" href="#" aria-label="Next" data-page="next">
                        <span aria-hidden="true"><i class="fa-solid fa-arrow-right"></i></span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <div class="modal fade" id="addMaterialModal" tabindex="-1" aria-labelledby="addMaterialModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMaterialModalLabel">Adicionar Material</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('index.php/CatalogoController/salvar_material'); ?>" method="post">
                        <div class="form-group">
                            <label for="nome">Nome do Material</label>
                            <input type="text" name="nome" class="form-control" id="nome" required>
                        </div>
                        <div class="form-group">
                            <label for="preco">Preço</label>
                            <input type="number" step="0.01" name="preco" class="form-control" id="preco" required>
                        </div>
                        <div class="form-group">
                            <label for="quantidade">Quantidade</label>
                            <input type="number" name="quantidade" class="form-control" id="quantidade" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function(){
            const rowsPerPage = 10;
            const rows = $('#materialTableBody tr');
            const rowsCount = rows.length;
            const pageCount = Math.ceil(rowsCount / rowsPerPage);
            const pagination = $('.pagination');

            let currentPage = 1;

            for (let i = 1; i <= pageCount; i++) {
                $('<li class="page-item"><a class="page-link" href="#" data-page="' + i + '">' + i + '</a></li>').insertBefore('#nextPage');
            }

            displayRows(currentPage);

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
                
                $('.pagination .page-item').removeClass('active');
                $('.pagination .page-item').eq(page).addClass('active');

                $('#prevPage').toggleClass('disabled', page === 1);
                $('#nextPage').toggleClass('disabled', page === pageCount);
            }

            $('#searchInput').on('keyup', function(){
                const value = $(this).val().toLowerCase();
                $('#materialTableBody tr').filter(function(){
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });

            setTimeout(function() {
                $('.alert-success').fadeOut('slow');
            }, 3000);
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
