<?php

use App\Models\Google\GoogleApi;
use App\Template\Template;

$h = new Template();

$h->TITULO   = "LOGIN";
$h->KEYWORDS = "Home";

$h->adminKit();
$GAPI = new GoogleApi();

$h->addStyle("assets/css/main-login.css");
$h->header();
?>

<body>
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Register -->
                <div class="card">
                    <div class="card-body">
                        <h4 class="mb-2">¡Bienvenido! 👋</h4>
                        <p class="mb-4">Por favor ingresa tu usuario y contraseña para continuar.</p>

                        <form id="form-login" class="mb-3" action="index.html" method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Usuario o correo</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Ingresa tus credenciales" autofocus="">
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Contraseña</label>
                                    <a href="#" id="recobery_password">
                                        <small>¿Olvitaste tu contraseña?</small>
                                    </a>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password" placeholder="············" aria-describedby="password">
                                    <span class="input-group-text cursor-pointer" id="password_show"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember-me" disabled>
                                    <label class="form-check-label" for="remember-me"> Recuerdame </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit" id="send_data">Ingresar</button>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col">
                                <div class="alert shadow" id="content-errors" style="display: none;">
                                    <span class="info-box-icon bg-warning"><i class="bi bi-dash-circle-dotted"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-number">Regular</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <?php
    echo $GAPI->useRecaptcha();
    $h->addScript("js/login/login.js");
    echo $h->scripts();
    ?>
</body>

</html>