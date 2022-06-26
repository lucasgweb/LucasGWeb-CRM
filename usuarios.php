<?php
require 'config.php';
require_once 'models/Auth.php';
require_once 'dao/UserDaoMySql.php';

$auth = new Auth($pdo, $base);

$userInfo = $auth->checkToken();
$userDao = new UserDaoMySql($pdo);
$allUsers = $userDao->findAll();

$disabled = '';
$noActive = '';

if ($userInfo->getLevel() != 1) {
    $disabled = 'disabled';
    $noActive = 'not-active';
}

require 'partials/header.php';
require 'partials/navbar.php';
require 'partials/sidebar.php';
?>


<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Administrar Usuarios</h1>
        <blockquote><i>Gestión de Usuarios</i></blockquote>
        <ol class="breadcrumb mb-4 justify-content-end">
            <li class="breadcrumb-item"><a href="index.php">index</a></li>
            <li class="breadcrumb-item active">usuarios</li>
        </ol>

        <div class="card mb-4">
            <div class="card-body">
                <!-- AGREGAR LEAD-->
                <div class="row" style="margin-left: 5px">
                    <div class="col">
                        <button type="button" class=" btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#newuser">
                            + Agregar Usuario
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="newuser" tabindex="-1" aria-labelledby="ModalLabelInsert"
                             aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="ModalLabelInsert">Agregar Usuario</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="modal-form">
                                            <form method="post" action="<?= $base; ?>/new_user_action.php">
                                                <div class="row">
                                                    <div class="col">
                                                        <input type="text" class="form-control"
                                                               placeholder="Ingresar Nombre" <?= $disabled; ?>
                                                               aria-label="Nombre" name="name">
                                                    </div>
                                                    <div class="col">
                                                        <input type="email" class="form-control"
                                                               placeholder="Ingresar Correo" <?= $disabled; ?>
                                                               aria-label="Email" name="email">
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col">
                                                        <select class="form-select" name="selective" <?= $disabled; ?>>
                                                            <option selected>Perfil</option>
                                                            <option value="1">Administrador</option>
                                                            <option value="2">Asesor</option>
                                                        </select>
                                                    </div>
                                                    <div class="col">
                                                        <input type="password" class="form-control"
                                                               placeholder="Ingresar Contraseña" aria-label="Contraseña"
                                                               name="password" <?= $disabled; ?>>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="modal-footer">
                                                    <input type="submit" class="btn btn-primary"
                                                           value="Agregar" <?= $disabled; ?>>
                                                    <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Cerrar
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table id="datatablesSimple" class="table table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Usuario</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Usuario</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        <?php foreach ($allUsers as $item): ?>

                            <?php
                            if ($item->getEstado() === 1) {
                                $estado = '<span class="btn btn-success btn-sm">Activado</span>';
                            } else {
                                $estado = '<span class="btn btn-danger btn-sm">Inactivo</span>';
                            }
                            ?>
                            <tr>
                                <th scope="row"><?= $item->getId(); ?></th>
                                <td><?= $item->getName(); ?></td>
                                <td><?= $estado; ?></td>
                                <td>

                                    <div class="btn-group me-2" role="group" aria-label="Editar Usuario">
                                        <a type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                           data-bs-target="#exampleModal" data-bs-whatever="<?= $item->getId(); ?>">
                                            <i class="bi bi-pen text-white"></i>
                                        </a>

                                        <?php if ($userInfo->getLevel() === 1): ?>
                                        <a <?= $disabled; ?>
                                                href="<?= $base; ?>/delete_action.php?id=<?= $item->getId(); ?>"
                                                type="button" class=" btn btn-danger btn-sm"
                                                onclick="return confirm('Tem certeza que deseja excluir?')">
                                            <i class="bi bi-trash3 text-white"></i>
                                        </a>
                                    </div>


                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="exampleModalLabel">Editar Usuario</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="<?= $base; ?>/update_user.php">
                                    <div class="mb-3">

                                        <input type="hidden" id="estado" name="id">
                                        <select class="form-select" name="selective" <?= $disabled; ?>>
                                            <option selected>Estado</option>
                                            <option value="1">Activado</option>
                                            <option value="2">Inactivo</option>
                                        </select>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="submit" class="btn btn-primary" value="Guardar" <?= $disabled; ?>>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar
                                        </button>

                                    </div>
                                </form>
                            </div>


                        </div>

                    </div>

                </div>
            </div>
        </div>
</main>
<script>
    var exampleModal = document.getElementById('exampleModal')
    exampleModal.addEventListener('show.bs.modal', function (event) {
        // Button that triggered the modal
        var button = event.relatedTarget
        // Extract info from data-bs-* attributes
        var recipient = button.getAttribute('data-bs-whatever')
        // If necessary, you could initiate an AJAX request here
        // and then do the updating in a callback.
        //
        // Update the modal's content.
        var modalTitle = exampleModal.querySelector('.modal-title')
        var modalBodyInput = exampleModal.querySelector('#estado')

        modalTitle.textContent = 'Editar estado'
        modalBodyInput.value = recipient

    })
</script>
<?php require 'partials/footer.php'; ?>

