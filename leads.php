<?php


require_once 'config.php';
require_once 'models/Auth.php';
require_once 'dao/UserDaoMySql.php';
require_once 'dao/LeadDaoMySql.php';

$auth = new Auth($pdo, $base);

$userInfo = $auth->checkToken();

$userDao = new UserDaoMySql($pdo);

$allUsers = $userDao->findAll();
$allLeads = [];

$leadDao = new  LeadDaoMySql($pdo);

$dadosBusca = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$allLeads = $leadDao->findAll();


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
        <h1 class="mt-4">Administrar Leads</h1>
        <blockquote><i>Gestión de Leads</i></blockquote>
        <ol class="breadcrumb mb-4 justify-content-end">
            <li class="breadcrumb-item"><a href="index.php">index</a></li>
            <li class="breadcrumb-item active">leads</li>
        </ol>
        <!-- <div class="card mb-4">
             <div class="card-body">
                 DataTables is a third party plugin that is used to generate the demo table below. For more information about DataTables, please visit the
                 <a target="_blank" href="https://datatables.net/">official DataTables documentation</a>
             </div>
         </div>
         -->
        <div class="card mb-4">
            <div class="card-body">
                <form class="row justify-content-center" method="post" action="">
                    <div class="col-auto">
                        <label>Fecha Inicío:
                            <input type="date" class="form-control" placeholder="Fecha inicio" name="startDate">
                        </label>
                    </div>
                    <div class="col-auto">
                        <label>Fecha Fin:
                            <input type="date" class="form-control " placeholder="Fecha inicio" name="endDate">
                        </label>
                    </div>
                    <div class="col-auto">
                        <label>Asesor:

                            <select class="form-select" id="autoSizingSelect" name='asesor'>
                                <option selected>Seleccionar asesor</option>
                                <?php foreach ($allUsers as $user) : ?>
                                    <option value="<?= $user->getId(); ?>"><?= $user->getName(); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </label>
                    </div>
                    <div class="col-auto">
                        <br>
                        <button type="submit" class="btn btn-success" value="pesquisar" name="PesquisarEntreDatas">+
                            Consultar
                        </button>
                    </div>
                </form>
                <?php
                if (!empty($dadosBusca['PesquisarEntreDatas'])) {
                    $startDate = $dadosBusca['startDate'];
                    $endDate = $dadosBusca['endDate'];
                    $asesorBusca = $dadosBusca['asesor'];


                    if ($startDate && $endDate && ($asesorBusca === 'Seleccionar asesor')) {
                        $allLeads = $leadDao->findByDates($startDate, $endDate);
                    } elseif ($startDate && $endDate && ($asesorBusca !== 'Seleccionar asesor')) {
                        $allLeads = $leadDao->findByDatesAsesor($startDate, $endDate, $asesorBusca);
                    } else if ($asesorBusca !== 'Seleccionar asesor') {
                        $allLeads = $leadDao->findByAsesor($asesorBusca);

                    } else {
                        $allLeads = $leadDao->findAll();
                    }


                }
                ?>

                <?php ?>

                <!-- AGREGAR LEAD-->
                <div class="row" style="margin-left: 5px">
                    <div class="col">
                        <button type="button" class=" btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#newlead">
                            + Agregar Lead
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="newlead" tabindex="-1" aria-labelledby="exampleModalLabel"
                             aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" style="width: 400px">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="exampleModalLabel">Agregar Lead</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="modal-form">
                                            <form action="<?= $base; ?>/new_lead_action.php" method="post">
                                                <div class="row">
                                                    <div class="col">
                                                        <input type="text" class="form-control" placeholder="Nombre"
                                                               aria-label="Nombre" name="name" <?= $disabled; ?>>
                                                    </div>
                                                    <div class="col">
                                                        <input type="text" class="form-control" placeholder="Curso"
                                                               aria-label="Curso" name="course" <?= $disabled; ?>>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col">
                                                        <select class="form-select" name="user" <?= $disabled; ?>>
                                                            <option selected>Seleccione un Asesor</option>
                                                            <?php foreach ($allUsers as $user) : ?>
                                                                <option value="<?= $user->getId(); ?>"><?= $user->getName(); ?></option>
                                                            <?php endforeach; ?>
                                                        </select>

                                                    </div>
                                                    <div class="col">
                                                        <input type="text" class="form-control" placeholder="Telefono"
                                                               aria-label="Telefono" name="phone" <?= $disabled; ?>>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col">
                                                        <input type="email" class="form-control" placeholder="Email"
                                                               aria-label="Email" name="email" <?= $disabled; ?>>
                                                    </div>
                                                    <div class="col">
                                                        <input type="text" class="form-control" placeholder="Canal"
                                                               aria-label="Canal" name="canal" <?= $disabled; ?>>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col">
                                                        <textarea class="form-control" rows="3" placeholder="Comentario"
                                                                  name="comments" <?= $disabled; ?>></textarea>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="modal-footer">
                                                    <input type="submit" class=" btn btn-primary"
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
                            <th>Fecha registro</th>
                            <th>Nombre</th>
                            <th>Curso</th>
                            <th>Asesor</th>
                            <th>Telefono</th>
                            <th>Email</th>
                            <th>Estado venta</th>
                            <th>Estado</th>
                            <th>Canal</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Fecha registro</th>
                            <th>Nombre</th>
                            <th>Curso</th>
                            <th>Asesor</th>
                            <th>Telefono</th>
                            <th>Email</th>
                            <th>Estado venta</th>
                            <th>Estado</th>
                            <th>Canal</th>
                            <th>Acciones</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        <?php foreach ($allLeads as $item): ?>

                            <?php
                            $asesorObj = $userDao->findById($item->getIdUser());
                            ?>
                            <tr>
                                <th scope="row"><?= $item->getId(); ?></th>
                                <td><?= $item->getDate(); ?></td>
                                <td><?= $item->getName(); ?></td>
                                <td><?= $item->getCourse(); ?></td>
                                <?php
                                if ($asesorObj) {
                                    $asesor = $asesorObj->getName();
                                } else {
                                    $asesor = 'Sin Asesor';
                                }
                                ?>

                                <td><?= $asesor; ?></td>
                                <td><?= $item->getPhone(); ?></td>
                                <td><?= $item->getEmail(); ?></td>
                                <?php
                                $idEstado = $item->getStatus();
                                $estadoVenta = $leadDao->estadoVenta($item->getStatus());
                                ?>

                                <td><?= $estadoVenta; ?></td>
                                <?php
                                if ($asesorObj) {
                                    if ($asesorObj->getEstado() === 1) {
                                        $estado = '<span class="btn btn-success btn-sm">Activado</span>';
                                    }
                                } else {
                                    $estado = '<span class="btn btn-danger btn-sm">Inactivo</span>';
                                }
                                ?>
                                <td><?= $estado; ?></td>
                                <td><?= $item->getCanal(); ?></td>
                                <td>

                                    <div class="btn-group me-2" role="group" aria-label="Editar Leads">
                                        <a class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                           data-bs-target="#exampleModal" data-bs-whateverid="<?= $item->getId(); ?>"
                                           data-bs-whatevername="<?= $item->getName(); ?>"
                                           data-bs-whateverEmail="<?= $item->getEmail(); ?>"
                                           data-bs-whateverphone="<?= $item->getPhone(); ?>"
                                           data-bs-whatevercourse="<?= $item->getCourse(); ?>"
                                           data-bs-whatevercanal="<?= $item->getCanal(); ?>"
                                           data-bs-whatevercomments="<?= $item->getComment(); ?>"
                                           data-bs-whateveriduser="<?= $item->getIdUser(); ?>">
                                            <i class="bi bi-pen text-white"></i>
                                        </a>
                                        <button type="button" class=" btn btn-success btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editasesor"
                                                data-bs-whateveridlead="<?= $item->getId(); ?>">
                                            <i class="bi bi-person-plus"></i>
                                        </button>
                                        <a class="btn btn-danger btn-sm bt"
                                           href="<?= $base; ?>/deletar_lead_action.php?id=<?= $item->getId(); ?>"
                                           onclick="return confirm('Tem certeza que deseja excluir?')">
                                            <i class="bi bi-trash"
                                               style="background-color: #d03333; color: azure"></i>
                                        </a>


                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="modal-form">
                                        <form action="<?= $base; ?>/editar_lead_action.php" method="post">
                                            <input type="hidden" name="idUser" id="getIdUser">
                                            <input type="hidden" name="id" id="getId">
                                            <div class="row">
                                                <div class="col">
                                                    <input type="text" id="getName" class="form-control"
                                                           placeholder="Nombre"
                                                           aria-label="Nombre" name="name" <?= $disabled; ?>>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col">
                                                    <input type="email" id="getEmail" class="form-control"
                                                           placeholder="Email"
                                                           aria-label="Email" name="email" <?= $disabled; ?>>
                                                </div>
                                                <div class="col">
                                                    <input type="text" id="getPhone" class="form-control"
                                                           aria-label="Telefono" name="phone" <?= $disabled; ?>
                                                           placeholder="Telefono/Celular">
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col">
                                                    <input type="text" id="getCourse" class="form-control"
                                                           placeholder="Curso"
                                                           aria-label="Curso" name="course" <?= $disabled; ?>>
                                                </div>
                                                <div class="col">
                                                    <input type="text" id="getCanal" class="form-control"
                                                           placeholder="Canal"
                                                           aria-label="Canal" name="canal" <?= $disabled; ?>>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col">
                                                        <textarea class="form-control getComments" rows="3"
                                                                  placeholder="Comentario"
                                                                  name="comments"<?= $disabled; ?>></textarea>
                                                </div>

                                            </div>
                                            <br>
                                            <div class="modal-footer">
                                                <input type="submit" class=" btn btn-primary"
                                                       value="Guardar Cambios" <?= $disabled; ?>>

                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    Cerrar
                                                </button>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="editasesor" tabindex="-1" aria-labelledby="ModalLabelInsert"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="ModalLabelInsert">Asignar Asesor(a)</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-form">
                            <form method="post" action="<?= $base; ?>/editar_lead_action.php">
                                <input type="hidden" name="idlead" id="idLead">
                                <div class="row">
                                    <div class="col">
                                        <select class="form-select" name="asesor" <?= $disabled; ?>>
                                            <option selected>Seleccione un Asesor</option>
                                            <?php foreach ($allUsers as $user) : ?>
                                                <option value="<?= $user->getId(); ?>"><?= $user->getName(); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <div class="modal-footer">
                                    <input type="submit" class="btn btn-primary"
                                           value="Asignar" <?= $disabled; ?>>
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
</main>
<script>
    var exampleModal = document.getElementById('exampleModal')
    exampleModal.addEventListener('show.bs.modal', function (event) {
        // Button that triggered the modal
        var button = event.relatedTarget
        // Extract info from data-bs-* attributes
        var id = button.getAttribute('data-bs-whateverid')
        var name = button.getAttribute('data-bs-whatevername')
        var email = button.getAttribute('data-bs-whateveremail')
        var phone = button.getAttribute('data-bs-whateverphone')
        var course = button.getAttribute('data-bs-whatevercourse')
        var canal = button.getAttribute('data-bs-whatevercanal')
        var comments = button.getAttribute('data-bs-whatevercomments')
        var iduser = button.getAttribute('data-bs-whateveriduser')
        // If necessary, you could initiate an AJAX request here
        // and then do the updating in a callback.
        //
        // Update the modal's content.
        var modalTitle = exampleModal.querySelector('.modal-title')
        var modalBodyInputId = exampleModal.querySelector('#getId')
        var modalBodyInputName = exampleModal.querySelector('#getName')
        var modalBodyInputEmail = exampleModal.querySelector('#getEmail')
        var modalBodyInputPhone = exampleModal.querySelector('#getPhone')
        var modalBodyInputCourse = exampleModal.querySelector('#getCourse')
        var modalBodyInputCanal = exampleModal.querySelector('#getCanal')
        var modalBodyInputIdUser = exampleModal.querySelector('#getIdUser')
        var modalTextArea = exampleModal.querySelector('.getComments')

        modalTitle.textContent = 'Editar Lead'
        modalBodyInputId.value = id
        modalBodyInputName.value = name
        modalBodyInputEmail.value = email
        modalBodyInputPhone.value = phone
        modalBodyInputCourse.value = course
        modalBodyInputCanal.value = canal
        modalBodyInputIdUser.value = iduser
        modalTextArea.textContent = comments


    })

    var editAsesor = document.getElementById('editasesor')
    editAsesor.addEventListener('show.bs.modal', function (event) {
        // Button that triggered the modal
        var button = event.relatedTarget
        // Extract info from data-bs-* attributes
        var idLead = button.getAttribute('data-bs-whateveridlead')
        // If necessary, you could initiate an AJAX request here
        // and then do the updating in a callback.
        //
        // Update the modal's content.
        var modalBodyInput = editAsesor.querySelector('#idLead')

        modalBodyInput.value = idLead

    })
</script>

<?php require 'partials/footer.php'; ?>
