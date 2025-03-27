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
        return `<div class="table-responsive text-nowrap">
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
        // id	"35a1ebb4-2bb2-4c80-a30f-feb2ad87f386"
        // username	"ing.leonardo"
        // correo	"ing.leonardovaz@gmail.com"
        // nombre	"Leonardo"
        // apellido	"Vazquez"
        // password	"$2y$10$2Jn7LP3StCgvvb5Tc4bCtupm1/jeX70.dF/F/AjIck04ggqrC.Jd6"
        // rol	"admin"
        // estado	"activo"
        // ultimo_acceso	null
        // created_at	"2025-03-26 00:19:39.518708"
        // updated_at	null
        return `<tr>
                    <td><strong>${row.username}</strong></td>
                    <td>${row.nombre} ${row.apellido}</td>
                    <td>${row.rol.charAt(0).toUpperCase() + row.rol.slice(1)}</td>
                    <td><span class="badge bg-label-${row.estado === 'activo' ? 'success' : 'danger'} me-1">${row.estado.charAt(0).toUpperCase() + row.estado.slice(1)}</span></td>
                    <td>${row.ultimo_acceso ? row.ultimo_acceso : 'Sin accesos'}</td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="javascript:void(0);" onclick="usuarios.editar('${row.id}')"><i class="bx bx-edit-alt me-1"></i> Editar</a>
                                <a class="dropdown-item" href="javascript:void(0);" onclick="usuarios.permisos('${row.id}')"><i class="bx bx-lock-alt me-1"></i> Permisos</a>
                                <a class="dropdown-item text-danger" href="javascript:void(0);" onclick="usuarios.eliminar('${row.id}')"><i class="bx bx-trash me-1"></i> Eliminar</a>
                            </div>
                        </div>
                    </td>
                </tr>`
    }


}

export default new ModelUsuario();  