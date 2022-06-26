<?php

require 'config.php';
require_once 'models/Auth.php';
require_once 'dao/UserDaoMySql.php';
require_once 'dao/LeadDaoMySql.php';

$auth = new Auth($pdo, $base);

$userInfo = $auth->checkToken();

$userDao = new UserDaoMySql($pdo);

$allUsers = $userDao->findAll();

$leadDao = new  LeadDaoMySql($pdo);

$allLeads = $leadDao->findAll();


require 'partials/header.php';
require 'partials/navbar.php';
require 'partials/sidebar.php';
?>


<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Importar Leads</h1>
        <blockquote>Importar Leads</blockquote>
        <ol class="breadcrumb mb-4 justify-content-end">
            <li class="breadcrumb-item"><a href="index.php">index</a></li>
            <li class="breadcrumb-item active">importar_leads</li>
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
                <div class="row justify-content-center">
                    <div class="col-sm">
                        <form method="post">
                            <div class="input-group">
                                <input type="file" class="form-control" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                                <button class="btn btn-outline-success" type="submit" id="inputGroupFileAddon04">Registrar Datos</button>
                            </div>
                        </form>
                    </div>

                </div>
                <div class="row justify-content-center" style="margin-top: 20px">
                    <div class="col-sm-auto">
                        <div>
                            <img src="assets/img/excel.png" width="500">
                        </div>
                    </div>
                </div>
            </div>
        </div>
</main>

<?php require 'partials/footer.php'; ?>

