<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Material</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Adicionar Material</h1>
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
</body>
</html>
