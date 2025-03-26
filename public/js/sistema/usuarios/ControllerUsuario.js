import ModelUsuario from "./ModelUsuario.js";

class ControllerUsuario {
    modal = null;

    construir(filter = {}) {
        this.create();
    }
    async init() {
        this.modal = $("#userModal");
        this.construir();
    }
    create() {
        this.modal.modal('show');
        const form = this.modal.find('#userForm').off();
        form[0].reset();

        form.on('submit', async (e) => {
            e.preventDefault();
            const data = new FormData(e.currentTarget);
            const response = await ModelUsuario.getUsuarios('create', data);
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

}

export default new ControllerUsuario();