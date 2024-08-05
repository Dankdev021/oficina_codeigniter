<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuários</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="main-header">
            <h1>Usuários</h1>
        </div>
        <button class="btn btn-primary" data-toggle="modal" data-target="#createUserModal">Adicionar Usuário</button>

        <table class="table table-dark table-hover mt-5">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Email</th>
                    <th>Tipo</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?= $usuario->nome; ?></td>
                    <td><?= $usuario->cpf; ?></td>
                    <td><?= $usuario->email; ?></td>
                    <td><?= $usuario->tipo_usuario; ?></td>
                    <td>
                        <button class="btn btn-info" data-toggle="modal" data-target="#editUserModal<?= $usuario->id; ?>">Editar</button>
                        <a href="<?= base_url('index.php/UsuariosController/delete/'.$usuario->id); ?>" class="btn btn-danger">Excluir</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal para criação de usuário -->
    <div class="modal fade" id="createUserModal" tabindex="-1" role="dialog" aria-labelledby="createUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createUserModalLabel">Adicionar Usuário</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('index.php/UsuariosController/store'); ?>" method="post">
                        <div class="form-group">
                            <label for="nome">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" required>
                        </div>
                        <div class="form-group">
                            <label for="cpf">CPF</label>
                            <input type="text" class="form-control" id="cpf" name="cpf" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="senha">Senha</label>
                            <input type="password" class="form-control" id="senha" name="senha" required>
                        </div>
                        <div class="form-group">
                            <label for="tipo_usuario">Tipo de Usuário</label>
                            <select class="form-control" id="tipo_usuario" name="tipo_usuario" required>
                                <option value="admin">Admin</option>
                                <option value="usuario">Usuário</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="is_mecanico">É mecânico?</label>
                            <select class="form-control" id="is_mecanico" name="is_mecanico" required>
                                <option value="1">Sim</option>
                                <option value="0">Não</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modais para edição de usuário -->
    <?php foreach ($usuarios as $usuario): ?>
    <div class="modal fade" id="editUserModal<?= $usuario->id; ?>" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel<?= $usuario->id; ?>" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel<?= $usuario->id; ?>">Editar Usuário</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('index.php/UsuariosController/update/'.$usuario->id); ?>" method="post">
                        <div class="form-group">
                            <label for="nome">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" value="<?= $usuario->nome; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="cpf">CPF</label>
                            <input type="text" class="form-control" id="cpf" name="cpf" value="<?= $usuario->cpf; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= $usuario->email; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="tipo_usuario">Tipo de Usuário</label>
                            <select class="form-control" id="tipo_usuario" name="tipo_usuario" required>
                                <option value="admin" <?= $usuario->tipo_usuario == 'admin' ? 'selected' : ''; ?>>Admin</option>
                                <option value="usuario" <?= $usuario->tipo_usuario == 'usuario' ? 'selected' : ''; ?>>Usuário</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="is_mecanico">É mecânico?</label>
                            <select class="form-control" id="is_mecanico" name="is_mecanico" required>
                                <option value="1" <?= $this->db->where('user_id', $usuario->id)->get('mecanicos')->num_rows() > 0 ? 'selected' : ''; ?>>Sim</option>
                                <option value="0" <?= $this->db->where('user_id', $usuario->id)->get('mecanicos')->num_rows() == 0 ? 'selected' : ''; ?>>Não</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
