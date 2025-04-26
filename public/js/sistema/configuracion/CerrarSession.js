$(document).ready(function () {
    $(".cerrar_session").click(function () {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Serás desconectado del sistema",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'CERRAR SESIÓN',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(RUTA + 'api/auth/logout', {
                    method: 'POST',
                }).then(res => res.json()).then(data => {
                    if (data.status) {
                        window.location.href = RUTA + 'auth/login';
                    }
                })
            }
        })

    })
});