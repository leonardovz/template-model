<?php

use App\Template\Template;

$h = new Template();

$h->TITULO   = "Configuración del Sistema";
$h->KEYWORDS = "Configuración, Sistema, Ajustes";

$h->adminKit();
$h->addStyle("assets/css/main-login.css");
$h->header();
?>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <?php echo $h->AdminKitNavBarLeft('configuracion', 'config'); ?>

            <div class="layout-page">
                <?php echo $h->AdminKitNavBar(); ?>

                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row">
                            <div class="col-xxl">
                                <div class="card mb-4">
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        <h5 class="mb-0">Configuración del Sistema</h5>
                                        <small class="text-muted float-end">Ajustes generales</small>
                                    </div>
                                    <div class="card-body">
                                        <form id="config-form">
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label" for="site-name">Nombre del Sitio</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="site-name" placeholder="Mi Aplicación">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label" for="site-url">URL del Sitio</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="site-url" placeholder="https://midominio.com">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label" for="admin-email">Email Administrador</label>
                                                <div class="col-sm-10">
                                                    <div class="input-group input-group-merge">
                                                        <input type="text" id="admin-email" class="form-control" placeholder="admin" aria-label="admin">
                                                        <span class="input-group-text" id="admin-email-domain">@ejemplo.com</span>
                                                    </div>
                                                    <div class="form-text">Email para notificaciones del sistema</div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label" for="timezone">Zona Horaria</label>
                                                <div class="col-sm-10">
                                                    <select id="timezone" class="form-select">
                                                        <option value="America/Mexico_City">Ciudad de México (GMT-6)</option>
                                                        <option value="America/New_York">Nueva York (GMT-5)</option>
                                                        <option value="Europe/Madrid">Madrid (GMT+1)</option>
                                                        <option value="UTC">UTC</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label" for="debug-mode">Modo Debug</label>
                                                <div class="col-sm-10">
                                                    <div class="form-check form-switch mt-2">
                                                        <input class="form-check-input" type="checkbox" id="debug-mode">
                                                        <label class="form-check-label" for="debug-mode">Activar modo de depuración</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row justify-content-end">
                                                <div class="col-sm-10">
                                                    <button type="submit" class="btn btn-primary">Guardar Configuración</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <?php
    $h->addScript("js/sistema/config/config.js", 'module');
    echo $h->scripts();
    ?>
</body>