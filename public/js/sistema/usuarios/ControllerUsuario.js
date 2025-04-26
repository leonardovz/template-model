import ModelUsuario from "./ModelUsuario.js";

class ControllerUsuario {
    modal = null;
    container = null;
    usuarios = [];

    async construir(filter = {}) {
        const res = await ModelUsuario.fetch('show');
        if (!res.status) {
            Swal.fire({
                icon: res.response,
                html: `
                    <div class="mb-3">
                        <p><strong>Error:</strong> ${res.text}</p>
                    </div>
                `,
                confirmButtonText: 'Aceptar',
                showConfirmButton: true,
            });
            this.container.html(res.text); // Limpiar el contenido si hay error
            this.usuarios = [];
            return;
        }

        this.usuarios = res.data;
        this.container.html(ModelUsuario.table(res.data));
        this.user_accions();
        // this.create();

    }
    async init() {
        this.modal = $("#userModal");
        this.container = $("#container-usuarios");
        $("#crear-usuario").on("click", () => {
            this.create();
        });
        this.construir();
    }

    create() {
        this.modal.modal('show');
        const form = this.modal.find('#userForm').off();
        form[0].reset();
        const button = form.find('button[type="submit"]');
        button.html('Guardar');

        form.on('submit', async (e) => {
            e.preventDefault();
            const data = new FormData(e.currentTarget);
            const response = await ModelUsuario.fetch('create', data);
            if (response.status) {
                this.modal.modal('hide');
                Swal.fire({
                    icon: 'success',
                    html: `
                        <div class="mb-3">
                            <p><strong>Usuario:</strong> ${response.data.username}</p>
                            <p><strong>Contraseña:</strong> ${response.data.pwd}</p>
                        </div>
                    `,
                    confirmButtonText: 'Aceptar',
                    showConfirmButton: true,
                });
                this.construir();
            } else {
                this.modal.modal('hide');
                Swal.fire({
                    icon: response.response,
                    html: `
                        <div class="mb-3">
                            <p><strong>Error:</strong> ${response.text}</p>
                        </div>
                    `,
                    confirmButtonText: 'Aceptar',
                    showConfirmButton: true,
                }).then(() => {
                    this.modal.modal('show');
                });
            }
        });

    }

    user_accions() {
        this.container.find(".accion-usuario").on("click", async (e) => {
            e.preventDefault();
            const accion = $(e.currentTarget).attr("accion-type");
            const id_usuario = $(e.currentTarget).closest("tr").attr("attr-id");

            switch (accion) {
                case "create":
                    this.create();
                    break;
                case "update":
                    this.update(id_usuario, this.modal);
                    break;
                case "password":
                    this.change_password(id_usuario);
                    break;
                case "delete":
                    this.delete(id_usuario);
                    break;
            }
        });
    }
    update(id, modal) {
        const user = this.usuarios.find((user) => user.id === id);
        if (!user) {
            Swal.fire({
                icon: "error",
                html: `<div class="mb-3">
                            <p><strong>Error:</strong> Usuario no encontrado</p>
                        </div>`,
                confirmButtonText: "Aceptar",
                showConfirmButton: true,
            });
            return;
        }

        if (user) {
            modal.find("#username").val(user.username);
            modal.find("#correo").val(user.correo);
            modal.find("#nombre").val(user.nombre);
            modal.find("#apellido").val(user.apellido);
            modal.find("#rol").val(user.rol);
            modal.find("#estado").val(user.estado);
            modal.modal("show");
        }
        const form = modal.find("#userForm");
        form.off();
        form.on("submit", async (e) => {
            e.preventDefault();
            const button = form.find("button[type='submit']");
            button.attr("disabled", true);
            button.html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Enviando...`);

            const data = new FormData(e.currentTarget);
            data.append("id", user.id);
            // Add 1 second delay before sending the request
            await new Promise(resolve => setTimeout(resolve, 500));
            const response = await ModelUsuario.fetch("update", data);
            if (response.status) this.construir();
            await new Promise(resolve => setTimeout(resolve, 500));

            button.attr("disabled", false);
            button.html(`Guardar`);

            modal.modal("hide");
            Swal.fire({
                icon: response.response,
                html: `<div class="mb-3">${response.text}</div>`,
                confirmButtonText: "Aceptar",
                showConfirmButton: true,
            }).then(() => {
                if (!response.status) {
                    modal.modal("show");
                } else {

                }
            });
        })
    }
    delete(id) {
        Swal.fire({
            title: "¿Estás seguro?",
            text: "Esta acción no se puede deshacer",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then(async (result) => {
            if (result.isConfirmed) {
                const data = new FormData();
                data.append('id', id);
                data.append('eliminado', 1);

                const response = await ModelUsuario.fetch('update', data);

                Swal.fire({
                    icon: response.response,
                    html: `<div class="mb-3">${response.text}</div>`,
                    confirmButtonText: 'Aceptar',
                    showConfirmButton: true
                });

                if (response.status) {
                    this.construir();
                }
            }
        });
    }
    change_password(id_usuario) {
        const user = this.usuarios.find((user) => user.id === id_usuario);
        if (!user) {
            Swal.fire({
                icon: "error",
                html: `<div class="mb-3">
                            <p><strong>Error:</strong> Usuario no encontrado</p>
                        </div>`,
                confirmButtonText: "Aceptar",
                showConfirmButton: true,
            });
            return;
        }

        Swal.fire({
            title: 'Cambiar contraseña',
            html: `
                <div class="mb-3">
                    <p><strong>Usuario:</strong> ${user.username}</p>
                    <div class="input-group">
                        <input type="text" id="password" class="form-control" placeholder="Nueva contraseña">
                        <button type="button" id="generate-password" class="btn btn-outline-secondary">
                            <i class="fas fa-key"></i> Generar
                        </button>
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Guardar',
            cancelButtonText: 'Cancelar',
            didOpen: () => {
                // Función para generar contraseña aleatoria
                const generateRandomPassword = () => {
                    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()';
                    let password = '';
                    for (let i = 0; i < 10; i++) {
                        password += chars.charAt(Math.floor(Math.random() * chars.length));
                    }
                    return password;
                };

                // Asignar evento al botón de generar contraseña
                document.getElementById('generate-password').addEventListener('click', () => {
                    document.getElementById('password').value = generateRandomPassword();
                });
            },
            preConfirm: () => {
                const password = document.getElementById('password').value;
                if (!password) {
                    Swal.showValidationMessage('Debe ingresar una contraseña');
                    return false;
                }
                return password;
            }
        }).then(async (result) => {
            if (result.isConfirmed) {
                const password = result.value;

                // Crear FormData y enviar solicitud
                const data = new FormData();
                data.append('id', id_usuario);
                data.append('password', password);

                // Mostrar indicador de carga
                Swal.fire({
                    title: 'Actualizando contraseña',
                    html: 'Por favor espere...',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });

                // Enviar solicitud al servidor
                const response = await ModelUsuario.fetch('update', data);

                // Mostrar resultado
                Swal.fire({
                    icon: response.response,
                    title: response.status ? 'Éxito' : 'Error',
                    html: `<div class="mb-3">${response.text}</div>`,
                    confirmButtonText: 'Aceptar',
                    showConfirmButton: true
                });

                // Actualizar la tabla si fue exitoso
                if (response.status) {
                    this.construir();
                }
            }
        });
    }
}
export default new ControllerUsuario();