<?php

use App\Config\Config;
use App\Template\Template;

new SessionManager();

$h = new Template();

$h->TITULO   = "Panel de Control de Usuarios";
$h->KEYWORDS = "usuarios, administración, panel de control";

$h->adminKit();
$h->addStyle("assets/css/main-login.css");
$h->header();
?>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <?php echo $h->AdminKitNavBarLeft('configuracion', 'usuarios'); ?>

            <div class="layout-page">
                <?php echo $h->AdminKitNavBar('configuracion', 'usuarios'); ?>

                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <!-- Header -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="d-flex align-items-center row">
                                        <div class="col-sm-7">
                                            <div class="card-body">
                                                <h5 class="card-title text-primary">Administración de Usuarios</h5>
                                                <p class="mb-4">Gestione los usuarios del sistema, permisos y roles desde este panel.</p>
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userModal">
                                                    <i class="bx bx-plus me-1"></i> Nuevo Usuario
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Filters and Search -->
                        <div class="row mb-4">
                            <div class="col-md-6 col-12 mb-3 mb-md-0">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bx bx-search"></i></span>
                                    <input type="text" class="form-control" placeholder="Buscar usuarios..." aria-label="Buscar">
                                    <button class="btn btn-outline-primary" type="button">Buscar</button>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 text-md-end">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-outline-secondary">
                                        <i class="bx bx-export me-1"></i> Exportar
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="visually-hidden">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="javascript:void(0);">Excel</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);">PDF</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);">CSV</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Users Table -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">Listado de Usuarios</h5>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-outline-secondary">Todos</button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary">Activos</button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary">Inactivos</button>
                                        </div>
                                    </div>
                                    <div class="card-body px-0" id="container-usuarios">

                                    </div>
                                    <div class="card-footer">
                                        <nav aria-label="Page navigation">
                                            <ul class="pagination justify-content-center">
                                                <li class="page-item prev">
                                                    <a class="page-link" href="javascript:void(0);"><i class="tf-icon bx bx-chevrons-left"></i></a>
                                                </li>
                                                <li class="page-item active">
                                                    <a class="page-link" href="javascript:void(0);">1</a>
                                                </li>
                                                <li class="page-item">
                                                    <a class="page-link" href="javascript:void(0);">2</a>
                                                </li>
                                                <li class="page-item">
                                                    <a class="page-link" href="javascript:void(0);">3</a>
                                                </li>
                                                <li class="page-item next">
                                                    <a class="page-link" href="javascript:void(0);"><i class="tf-icon bx bx-chevrons-right"></i></a>
                                                </li>
                                            </ul>
                                        </nav>
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

    <!-- Modal para Nuevo/Editar Usuario -->
    <div class="modal fade" id="userModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Nuevo Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="userForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="username" class="form-label">Nombre de Usuario</label>
                                <input type="text" id="username" name="username" class="form-control" placeholder="usuario123" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="correo" class="form-label">Correo Electrónico</label>
                                <input type="email" id="correo" name="correo" class="form-control" placeholder="usuario@ejemplo.com" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Juan">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="apellido" class="form-label">Apellido</label>
                                <input type="text" id="apellido" name="apellido" class="form-control" placeholder="Pérez">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="rol" class="form-label">Rol</label>
                                <select id="rol" name="rol" class="form-select">
                                    <option value="">Seleccionar</option>
                                    <option value="admin">Administrador</option>
                                    <option value="vendedor">Vendedor</option>
                                    <option value="usuario">Usuario</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="estado" class="form-label">Estado</label>
                                <select id="estado" name="estado" class="form-select">
                                    <option value="activo">Activo</option>
                                    <option value="inactivo">Inactivo</option>
                                    <option value="pendiente">Pendiente</option>
                                </select>
                            </div>
                        </div>
                        <button id="send-form" class="btn btn-primary w-100" type="submit">Guardar</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <?php
    $h->addScript("js/sistema/usuarios/usuarios.js", 'module');
    echo $h->scripts(); ?>
</body>