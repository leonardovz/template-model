class Funciones {
    meses() {
        return [
            { 'name': "Enero", 'min': "En", },
            { 'name': "Febrero", 'min': "Feb", },
            { 'name': "Marzo", 'min': "Mar", },
            { 'name': "Abril", 'min': "Abr", },
            { 'name': "Mayo", 'min': "May", },
            { 'name': "Junio", 'min': "Jun", },
            { 'name': "Julio", 'min': "Jul", },
            { 'name': "Agosto", 'min': "Ag", },
            { 'name': "Septiembre", 'min': "Sep", },
            { 'name': "Octubre", 'min': "Oct", },
            { 'name': "Noviembre", 'min': "Nov", },
            { 'name': "Diciembre", 'min': "Dic", },
        ];
    }
    rellenar_cero(text, long = 5, relleno = '0') {
        let add_relleno = "";

        for (let i = (text + "").length; i < long; i++) add_relleno += relleno;

        return (add_relleno + text);
    }
    clear_spacing(text) {
        let new_text = "";
        text = text.split(" ");
        for (const palabra of text) { if (palabra != '') new_text += palabra + ' '; }
        return (new_text);
    }
    date_diff(init, end) {
        /**
         * @param {init} Fecha inicial en formato new Date()
         * @param {end} Fecha final en formato new Date()
         */
        const diferencia_ms = Math.abs(init - end); //Diferencia en ml segundos;

        const dias = parseInt(diferencia_ms / (1000 * 60 * 60 * 24)); // Dias de diferencia
        const all_hours = parseInt(diferencia_ms / (1000 * 60 * 60)); // Todas las horas de diferencia
        const all_min = parseInt(diferencia_ms / (1000 * 60)); //Todos los minutos de diferencia
        const all_seg = parseInt(diferencia_ms / (1000)); //Todos los segundos de diferencia


        const hours = (all_hours % 24); //Solo horas disponibles
        const minutes = all_min - (all_hours * 60); //solo minutos disponibles
        const seconds = all_seg - (all_min * 60); //solo segundos disponibles

        const data = {
            all_hours: parseInt(diferencia_ms / (1000 * 60 * 60)),
            all_min: parseInt(diferencia_ms / (1000 * 60)),
            all_seg: parseInt(diferencia_ms / (1000)),
            days: parseInt(diferencia_ms / (1000 * 60 * 60 * 24)),
            hours: hours,
            minutes: minutes,
            seconds: seconds,
        };

        return data;
    }
    tiempo_transcurrido(date) {
        let diff = this.date_diff(date, new Date());

        let diferencia = ""
        if (diff.all_min < 1) {
            diferencia = 'Ahora'; // return (number) minutos
        } else if (diff.all_min < 60) {
            diferencia = diff.all_min + " min." + (diff.all_min == 1 ? "" : ""); // return (number) minutos
        } else if (diff.all_hours < 60) {
            diferencia = diff.all_hours + " hora" + (diff.all_hours == 1 ? "" : "s"); // return (number) horas
        } else if (diff.days < 28) {
            diferencia = diff.days + " día" + (diff.days == 1 ? "" : "s"); //return (number) dias
        } else {
            const meses = this.meses();
            let mes = meses[date.getMonth()];
            diferencia = date.getDate() + " de " + (mes.name.toLowerCase()) + " de " + date.getFullYear();
        }
        return diferencia;
    }
    formateo_fecha(fecha, hour = false) {
        const meses = this.meses();
        let date = this.rellenar_cero(fecha.getDate(), 2) + " de " + (meses[fecha.getMonth()].name).toLowerCase() + " de " + fecha.getFullYear();
        if (hour) date += ", " + this.formateo_tiempo(fecha);

        return date;
    }
    fecha_min(fecha) {
        const meses = this.meses();
        let date = this.rellenar_cero(fecha.getDate(), 2) + " " + (meses[fecha.getMonth()].min) + ". " + fecha.getFullYear();
        return date;
    }
    formateo_tiempo(fecha, all = false) {
        let hora = fecha.getHours();
        let min = fecha.getMinutes();
        let tiempo = (fecha.getHours() > 12) ? "PM" : "AM";

        if (all) {
            return (this.rellenar_cero(hora, 2)) + ":" + (this.rellenar_cero(min, 2));
        } else {
            hora = ((hora > 12) ? (hora - 12) : hora);
            return ((this.rellenar_cero(hora, 2)) + ":" + (this.rellenar_cero(min, 2)) + " " + tiempo);
        }
    }
    pasword_format(size = 8) {
        const text = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
        const numeric = "0123456789";
        const special = ".#@%&";

        const rules = [text, numeric, special];


        const random_char = (rules) => {
            let i_rule = Math.floor(Math.random() * rules.length);
            let i_word = Math.floor(Math.random() * rules[i_rule].length);
            return rules[i_rule][i_word];
        }

        let password = "";
        for (let i = 0; i < size; i++) {
            password += (random_char(rules));
        }
        return password;
    }
    number_format(amount, decimals) {

        amount += ''; // por si pasan un numero en vez de un string
        amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto

        decimals = decimals || 0; // por si la variable no fue fue pasada

        // si no es un numero o es igual a cero retorno el mismo cero
        if (isNaN(amount) || amount === 0)
            return parseFloat(0).toFixed(decimals);

        // si es mayor o menor que cero retorno el valor formateado como numero
        amount = '' + amount.toFixed(decimals);

        var amount_parts = amount.split('.'),
            regexp = /(\d+)(\d{3})/;

        while (regexp.test(amount_parts[0]))
            amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');

        return amount_parts.join('.');
    }
    json_formData(json) {
        const formData = new FormData();

        if (!json || !Object.keys(json).length) return formData;

        Object.entries(json).forEach(([key, value]) => {
            formData.append(key, value);
        });

        return formData;
    }
    json_formData(json) {
        const formData = new FormData();

        if (!json || !Object.keys(json).length) return formData;

        Object.entries(json).forEach(([key, value]) => {
            formData.append(key, value);
        });

        return formData;
    }

    stripHtml(htmlString) {
        // Crear un elemento temporal
        const tempDiv = document.createElement("div");

        // Asignar la cadena HTML al contenido del elemento
        tempDiv.innerHTML = htmlString;

        // Retornar solo el texto contenido, sin etiquetas
        return tempDiv.textContent || tempDiv.innerText || "";
    }

    truncateText(htmlString, maxLength) {
        // Convertir HTML a texto plano
        const plainText = this.stripHtml(htmlString);

        // Truncar el texto si excede la longitud máxima
        return plainText.length > maxLength
            ? plainText.substring(0, maxLength) + "..."
            : plainText;
    }

}

export default new Funciones();