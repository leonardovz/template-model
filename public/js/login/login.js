$(document).ready(function () {
    // Referencia al formulario de login
    const loginForm = $('#form-login');

    // Manejar el envío del formulario
    loginForm.on('submit', function (e) {
        e.preventDefault();

        // Obtener los valores del formulario
        const username = $('#username').val();
        const password = $('#password').val();

        // Validar campos requeridos
        if (!username || !password) {
            mostrarAlerta('warning', 'Por favor, complete todos los campos');
            return;
        }

        // Crear objeto FormData
        const formData = new FormData();
        formData.append('username', username);
        formData.append('password', password);

        // Mostrar indicador de carga
        const btnSubmit = $('#send_data');
        const btnText = btnSubmit.html();
        btnSubmit.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Procesando...').prop('disabled', true);

        // Ocultar alertas previas
        $('#content-errors').hide();

        grecaptcha.enterprise.ready(async function () {
            return await grecaptcha.enterprise.execute(recaptchaKey, {
                action: 'login'
            }).then(async function (token) {

                formData.append("captcha", token);


                fetch(RUTA + 'api/auth/login', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        // Restaurar botón
                        btnSubmit.html(btnText).prop('disabled', false);

                        if (data.status) {
                            // Login exitoso
                            mostrarAlerta('success', '¡Bienvenido! Iniciando sesión...');

                            // Redireccionar después de un breve retraso
                            setTimeout(function () {
                                window.location.href = RUTA + 'sistema/';
                            }, 1500);
                        } else {
                            // Login fallido
                            mostrarAlerta('danger', data.text || 'Error al iniciar sesión. Verifique sus credenciales.');
                        }
                    })
                    .catch(error => {
                        // Error de conexión
                        btnSubmit.html(btnText).prop('disabled', false);
                        mostrarAlerta('danger', 'Error de conexión. Intente nuevamente.');
                        console.error('Error de login:', error);
                    });




                /** **** **** **** */
            });
        });
    });

    // Función para mostrar alertas
    function mostrarAlerta(tipo, mensaje) {
        const alertElement = $('#content-errors');

        // Configurar clase y contenido según el tipo
        alertElement.removeClass('alert-success alert-danger alert-warning');
        alertElement.addClass('alert-' + tipo);

        // Cambiar el icono según el tipo
        let icono = 'bi-dash-circle-dotted';
        if (tipo === 'success') {
            icono = 'bi-check-circle';
        } else if (tipo === 'danger') {
            icono = 'bi-exclamation-circle';
        }

        // Actualizar contenido
        alertElement.find('.info-box-icon i').removeClass().addClass('bi ' + icono);
        alertElement.find('.info-box-number').text(mensaje);

        // Mostrar alerta
        alertElement.show();
    }

    // Alternar visibilidad de la contraseña
    $('#password_show').on('click', function () {
        const passwordInput = $('#password');
        const icon = $(this).find('i');

        if (passwordInput.attr('type') === 'password') {
            passwordInput.attr('type', 'text');
            icon.removeClass('bx-hide').addClass('bx-show');
        } else {
            passwordInput.attr('type', 'password');
            icon.removeClass('bx-show').addClass('bx-hide');
        }
    });

    // Limpiar alertas al escribir
    $('#username, #password').on('input', function () {
        $('#content-errors').hide();
    });

    // Manejar clic en recuperar contraseña
});