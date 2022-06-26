<?php
require_once 'config.php';


?>

<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">
            <div class="sb-sidenav-menu-heading">Menu</div>

            <a class="nav-link" href="<?= $base; ?>/usuarios.php">
                <div class="sb-nav-link-icon"><i class="bi bi-people-fill"></i></i></div>
                Usuarios
            </a>

            <div class="sb-sidenav-menu-heading">Clasificación</div>
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLeads"
               aria-expanded="false" aria-controls="collapseLayouts">
                <div class="sb-nav-link-icon"><i class="bi bi-arrow-up-right-circle-fill"></i></div>
                CRM
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseLeads" aria-labelledby="headingOne"
                 data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="<?=$base;?>/leads.php">Leads</a>
                    <a class="nav-link" href="<?=$base;?>/importar_leads.php"">Importar Leads</a>
                    <a class="nav-link" href="<?=$base;?>/panel_de_ventas.php">Panel de ventas</a>
                </nav>
            </div>
        </div>
    </div>
    <div class="sb-sidenav-footer">
        <div class="small">Logado en:</div>
        LCGTI
    </div>
</nav>
</div>
<div id="layoutSidenav_content">