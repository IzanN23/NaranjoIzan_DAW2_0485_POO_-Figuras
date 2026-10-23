// Estas validaciones del navegador dan respuesta inmediata al usuario.
// PHP vuelve a validar en el servidor: JavaScript se puede desactivar o evitar.

// Actualiza el mensaje junto a un campo y añade/quita el estilo de error.
function mostrarError(campo, mensaje) {
    let span = document.getElementById("error-" + campo.id);
    span.textContent = mensaje;
    if (mensaje !== "") {
        campo.classList.add("input-error");
    } else {
        campo.classList.remove("input-error");
    }
}

// Comprueba que una medida esté informada, tenga formato numérico y sea > 0.
function validarLado(campo) {
    // Acepta coma decimal y normaliza a punto antes de comprobar el formato.
    let valor = campo.value.trim().replace(",", ".");
    let nombre = campo.dataset.nombre;
    let mensaje = "";

    if (valor === "") {
        mensaje = nombre + " es obligatorio.";
    } else if (!/^[0-9]+(\.[0-9]+)?$/.test(valor)) {
        mensaje = nombre + " debe ser un número positivo (sin letras ni signo negativo).";
    } else if (parseFloat(valor) <= 0) {
        mensaje = nombre + " debe ser mayor que 0.";
    }

    mostrarError(campo, mensaje);
    return mensaje === "";
}

// Comprobación adicional, exclusiva del triángulo: desigualdad triangular.
function validarTriangulo() {
    let c1 = document.getElementById("lado1");
    let c2 = document.getElementById("lado2");
    let c3 = document.getElementById("lado3");
    // Si no existe el campo lado3, el formulario no corresponde a un triángulo.
    if (!c3) { return true; }

    // Convierte el texto de cada campo para poder comparar las sumas.
    let a = parseFloat(c1.value.replace(",", "."));
    let b = parseFloat(c2.value.replace(",", "."));
    let c = parseFloat(c3.value.replace(",", "."));

    // Si falta algún número, ya avisa el error propio de ese campo.
    if (isNaN(a) || isNaN(b) || isNaN(c)) { return true; }

    if (a + b > c && a + c > b && b + c > a) {
        return true;
    }
    mostrarError(c3, "Esos lados no forman un triángulo (la suma de dos lados debe ser mayor que el tercero).");
    return false;
}

function validarTipo(select) {
    // La opción vacía tiene value="", por eso indica que no se eligió figura.
    let mensaje = select.value === "" ? "Debes elegir una figura." : "";
    mostrarError(select, mensaje);
    return mensaje === "";
}

document.addEventListener("DOMContentLoaded", function () {

    // Ejecuta esta parte solo cuando existe el formulario para elegir figura.
    let formFigura = document.getElementById("formFigura");
    if (formFigura) {
        let select = document.getElementById("tipoFigura");
        // blur valida al salir del selector; submit vuelve a comprobar al enviar.
        select.addEventListener("blur", function () { validarTipo(select); });
        formFigura.addEventListener("submit", function (e) {
            if (!validarTipo(select)) { e.preventDefault(); }
        });
    }

    // Ejecuta esta parte solo cuando existe el formulario de medidas.
    let formLados = document.getElementById("formLados");
    if (formLados) {
        let campos = formLados.querySelectorAll("input[type=text]");

        // Valida cada campo cuando el usuario termina de editarlo.
        campos.forEach(function (campo) {
            campo.addEventListener("blur", function () {
                // Al salir de lado3, si tiene formato válido, también revisa el triángulo.
                if (validarLado(campo) && campo.id === "lado3") {
                    validarTriangulo();
                }
            });
        });

        formLados.addEventListener("submit", function (e) {
            let correcto = true;
            // Se revisan todos los campos, aunque alguno falle, para mostrar cada error.
            campos.forEach(function (campo) {
                if (!validarLado(campo)) { correcto = false; }
            });
            // Solo se compara la forma del triángulo si las medidas individuales valen.
            if (correcto && !validarTriangulo()) { correcto = false; }
            // Evita enviar el formulario si hay al menos una validación fallida.
            if (!correcto) { e.preventDefault(); }
        });
    }
});
