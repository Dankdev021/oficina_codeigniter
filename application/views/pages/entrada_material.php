<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Entrada de Material</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Registrar Entrada de Material</h1>
        <form action="<?= base_url('index.php/CatalogoController/entrada_material'); ?>" method="post">
            <div class="form-group">
                <label for="material_id">Material</label>
                <select name="material_id" class="form-control" id="material_id" required>
                    <?php foreach ($materiais as $material): ?>
                    <option value="<?= $material->id; ?>"><?= $material->nome; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="quantidade">Quantidade</label>
                <input type="number" name="quantidade" class="form-control" id="quantidade" required>
            </div>
            <button type="submit" class="btn btn-primary">Registrar Entrada</button>
        </form>
    </div>
</body>
</html>
