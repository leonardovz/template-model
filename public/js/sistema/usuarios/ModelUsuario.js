class ModelUsuario {
    constructor() {
        this.usuarios = []
    }

    async getUsuarios(uri = "mostrar", data = null) {
        return await fetch(`${RUTA}api/usuarios/${uri}`, { method: 'post', body: data })
            .then(res => res.json())
            .catch(err => {
                console.log(err.message);
                return { status: false, text: "Error en la conexión" + err.message, 'response': 'error' }
            });
    }


}

export default new ModelUsuario();  