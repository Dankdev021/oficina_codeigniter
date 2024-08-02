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
        <div class="top-bar">
            <div class="search-container">
                <input type="text" id="searchInput" placeholder="Pesquisar material..." class="form-control">
                <i class="fa fa-search"></i>
            </div>
            <?php if ($this->session->userdata('user_role') == 'admin'): ?>
                <div>
                    <a href="<?= base_url('index.php/CatalogoController/adicionar_material'); ?>" id="adicionarMaterialBtn" class="btn btn-primary">
                        <i class="fa-solid fa-plus"></i> Adicionar Material
                    </a>
                </div>
            <?php endif; ?>
        </div>
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Preço</th>
                    <th>Quantidade</th>
                </tr>
            </thead>
            <tbody id="materialTableBody">
                <?php foreach ($materiais as $material): ?>
                <tr>
                    <td><?= $material->nome; ?></td>
                    <td><?= 'R$ ' . number_format($material->preco, 2, ',', '.'); ?></td>
                    <td><?= $material->quantidade; ?></td>
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

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function(){
            const rowsPerPage = 10;
            const rows = $('#materialTableBody tr');
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
                $('#materialTableBody tr').filter(function(){
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
        });
    </script>
</body>
</html>
