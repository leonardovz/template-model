import Funciones from '../../models/Funciones.js';
class ModelUsuario {
    constructor() {
        this.usuarios = []
    }

    async fetch(uri = "mostrar", data = null) {
        return await fetch(`${RUTA}api/usuarios/${uri}`, { method: 'post', body: data })
            .then(res => res.json())
            .catch(err => {
                console.log(err.message);
                return { status: false, text: "Error en la conexión" + err.message, 'response': 'error' }
            });
    }
    table(data) {
        return `<div class="table-responsive text-nowrap" style="min-height: 300px;">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Usuario</th>
                                <th>Nombre</th>
                                <th>Rol</th>
                                <th>Estado</th>
                                <th>Último Acceso</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            ${data.map(row => this.rowTable(row)).join("")}
                        </tbody>
                    </table>
                </div>
        `;

    }
    rowTable(row) {
        return `<tr attr-id="${row.id}">
                    <td><strong>${row.username}</strong></td>
                    <td>${row.nombre} ${row.apellido}</td>
                    <td>${row.rol.charAt(0).toUpperCase() + row.rol.slice(1)}</td>
                    <td><span class="badge bg-label-${row.estado === 'activo' ? 'success' : 'danger'} me-1">${row.estado.charAt(0).toUpperCase() + row.estado.slice(1)}</span></td>
                    <td>${row.ultimo_acceso ? Funciones.tiempo_transcurrido(new Date(row.ultimo_acceso)) : 'Sin accesos'}</td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a accion-type="update" class="dropdown-item accion-usuario" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> Editar</a>
                                <a accion-type="password" class="dropdown-item accion-usuario" href="javascript:void(0);"><i class="bx bx-lock-alt me-1"></i> Contraseña</a>
                                <a accion-type="delete" class="dropdown-item accion-usuario text-danger" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Eliminar</a>
                            </div>
                        </div>
                    </td>
                </tr>`
    }


}

export default new ModelUsuario();  