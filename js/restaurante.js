console.log("Bienvenidos a AlimentTICO");

document.addEventListener("DOMContentLoaded", function () {

    let formulario = document.querySelector("form");
    let mensaje = document.getElementById("mensaje");
    mensaje.style.display = "none";

    formulario.addEventListener("submit", function (event) {
        event.preventDefault();

        let tipoAlimento = document.getElementById("tipoAlimento");
        let nombreAlimento = document.getElementById("nombreAlimento");
        let cantidad = document.getElementById("cantidad");
        let fechaDisponibilidad = document.getElementById("fechaDisponibilidad");
        let horaLimite = document.getElementById("horaLimite");
        let importante = document.getElementById("importante");

        if (tipoAlimento.value == "") {
            mensaje.innerHTML = "El tipo de alimento es obligatorio";
            mensaje.style.backgroundColor = "rgba(149, 24, 24, 0.758)";
            mensaje.style.display = "block";
            return;
        }

        if (nombreAlimento.value == "") {
            mensaje.innerHTML = "El nombre del alimento es obligatorio";
            mensaje.style.backgroundColor = "rgba(149, 24, 24, 0.758)";
            mensaje.style.display = "block";
            return;
        }

        if (cantidad.value == "") {
            mensaje.innerHTML = "La cantidad es obligatoria";
            mensaje.style.backgroundColor = "rgba(149, 24, 24, 0.758)";
            mensaje.style.display = "block";
            return;
        }

        if (fechaDisponibilidad.value == "") {
            mensaje.innerHTML = "La fecha de disponibilidad es obligatoria";
            mensaje.style.backgroundColor = "rgba(149, 24, 24, 0.758)";
            mensaje.style.display = "block";
            return;
        }

        let fechaHoy = new Date();
        let año = fechaHoy.getFullYear();
        let mes = fechaHoy.getMonth() + 1;
        let dia = fechaHoy.getDate();

        if (mes < 10) { mes = "0" + mes; }
        if (dia < 10) { dia = "0" + dia; }

        let fechaHoyStr = año + "-" + mes + "-" + dia;
        let fechaActualMostrar = dia + "-" + mes + "-" + año;

        if (fechaDisponibilidad.value < fechaHoyStr) {
            mensaje.innerHTML = "La fecha no puede ser anterior a hoy " + fechaActualMostrar;
            mensaje.style.backgroundColor = "rgba(149, 24, 24, 0.758)";
            mensaje.style.display = "block";
            return;
        }

        if (horaLimite.value == "") {
            mensaje.innerHTML = "La hora limite de recogida es obligatoria";
            mensaje.style.backgroundColor ="rgba(149, 24, 24, 0.758)";
            mensaje.style.display = "block";
            return;
        }

        if (fechaDisponibilidad.value == fechaHoyStr) {
            let horaActual = fechaHoy.getHours();
            let minutosActual = fechaHoy.getMinutes();
            if (minutosActual < 10) { minutosActual = "0" + minutosActual; }
            let horaActualStr = horaActual + ":" + minutosActual;

            if (horaLimite.value < horaActualStr) {
                mensaje.innerHTML = "La hora de recogida no puede ser anterior a la hora actual";
                mensaje.style.backgroundColor = "rgba(149, 24, 24, 0.758)";
                mensaje.style.display = "block";
                return;
            }
        }

        if (importante.value == "") {
            mensaje.innerHTML = "La informacion adicional es obligatoria";
            mensaje.style.backgroundColor = "rgba(149, 24, 24, 0.758)";
            mensaje.style.display = "block";
            return;
        }
        
        mensaje.innerHTML = "Donación agregada correctamente";
        mensaje.style.backgroundColor = "rgba(65, 201, 7, 0.8)";
        mensaje.style.display = "block";
        console.log("Donación agregada correctamente");

        setTimeout(function () {
            mensaje.style.display = "none";
        }, 5000);
    });

    let botonCancelar = document.getElementById("btnCancelar");

    botonCancelar.addEventListener("click", function () {
        mensaje.style.display = "none";
    });

});

 document.addEventListener("DOMContentLoaded", function () {
    let btnSidebar = document.getElementById("btnSidebar");
    let btnCerrar = document.getElementById("btnCerrarSidebar");
    let sidebar = document.getElementById("sidebar");

    if (btnSidebar) {
        btnSidebar.addEventListener("click", function () {
            sidebar.classList.add("abierto");
        });
    }

    if (btnCerrar) {
        btnCerrar.addEventListener("click", function () {
            sidebar.classList.remove("abierto");
        });
    }
});

// Perfil del restaurante
document.addEventListener("DOMContentLoaded", function () {

    let formPerfil = document.getElementById("formPerfil");
    if (!formPerfil) { return; }

    let mensaje = document.getElementById("mensaje");
    mensaje.style.display = "none";

    // Switches para activar y desactivar las horas
    let switches = document.querySelectorAll(".switch-dia");

    for (let i = 0; i < switches.length; i++) {
        let horarioCambioSwitch = switches[i];
        horarioCambioSwitch.addEventListener("change", function () {
            let dia = horarioCambioSwitch.id.replace("switch", "");
            let inputAbre = document.getElementById("abre" + dia);
            let inputCierra = document.getElementById("cierra" + dia);
            let labelEstado = document.getElementById("estado" + dia);

            if (horarioCambioSwitch.checked) {
                inputAbre.disabled = false;
                inputCierra.disabled = false;
                labelEstado.innerHTML = "Abierto";
            } else {
                inputAbre.disabled = true;
                inputAbre.value = "";
                inputCierra.disabled = true;
                inputCierra.value = "";
                labelEstado.innerHTML = "Cerrado";
            }
        });
    }

    // Validaciones del formulario del información del perfil
    formPerfil.addEventListener("submit", function (event) {
        event.preventDefault();

        let nombreNegocio = document.getElementById("nombreNegocio");
        let cedulaJuridica = document.getElementById("cedulaJuridica");
        let telefono = document.getElementById("telefono");
        let canton = document.getElementById("canton");
        let distrito = document.getElementById("distrito");
        let direccion = document.getElementById("direccion");
        let correo = document.getElementById("correo");
        let contrasena = document.getElementById("contrasena");

        if (nombreNegocio.value == "") {
            mensaje.innerHTML = "El nombre del negocio es obligatorio";
            mensaje.style.backgroundColor = "rgba(149, 24, 24, 0.758)";
            mensaje.style.display = "block";
            return;
        }

        if (cedulaJuridica.value == "") {
            mensaje.innerHTML = "La cédula jurídica es obligatoria";
            mensaje.style.backgroundColor = "rgba(149, 24, 24, 0.758)";
            mensaje.style.display = "block";
            return;
        }

        if (telefono.value == "") {
            mensaje.innerHTML = "El teléfono es obligatorio";
            mensaje.style.backgroundColor = "rgba(149, 24, 24, 0.758)";
            mensaje.style.display = "block";
            return;
        }

        if (canton.value == "") {
            mensaje.innerHTML = "El cantón es obligatorio";
            mensaje.style.backgroundColor = "rgba(149, 24, 24, 0.758)";
            mensaje.style.display = "block";
            return;
        }

        if (distrito.value == "") {
            mensaje.innerHTML = "El distrito es obligatorio";
            mensaje.style.backgroundColor = "rgba(149, 24, 24, 0.758)";
            mensaje.style.display = "block";
            return;
        }

        if (direccion.value == "") {
            mensaje.innerHTML = "La dirección exacta es obligatoria";
            mensaje.style.backgroundColor = "rgba(149, 24, 24, 0.758)";
            mensaje.style.display = "block";
            return;
        }

        if (correo.value == "") {
            mensaje.innerHTML = "El correo electrónico es obligatorio";
            mensaje.style.backgroundColor = "rgba(149, 24, 24, 0.758)";
            mensaje.style.display = "block";
            return;
        }

        if (!correo.value.includes("@") || !correo.value.includes(".")) {
            mensaje.innerHTML = "El correo no tiene un formato válido";
            mensaje.style.backgroundColor = "rgba(149, 24, 24, 0.758)";
            mensaje.style.display = "block";
            return;
        }

        // Validar contraseña solo si se quiere cambiar
        if (contrasena.value != "") {

            if (contrasena.value.length < 8) {
                mensaje.innerHTML = "La contraseña debe tener al menos 8 caracteres";
                mensaje.style.backgroundColor = "rgba(149, 24, 24, 0.758)";
                mensaje.style.display = "block";
                return;
            }

            if (contrasena.value == contrasena.value.toLowerCase()) {
                mensaje.innerHTML = "La contraseña debe tener al menos una letra mayuscula";
                mensaje.style.backgroundColor = "rgba(149, 24, 24, 0.758)";
                mensaje.style.display = "block";
                return;
            }

            let tieneNumero = false;

            for (let i = 0; i < contrasena.value.length; i++) {
                if (contrasena.value[i] >= "0" && contrasena.value[i] <= "9") {
                    tieneNumero = true;
                }
            }

            if (tieneNumero == false) {
                mensaje.innerHTML = "La contraseña debe tener al menos un número";
                mensaje.style.backgroundColor = "rgba(149, 24, 24, 0.758)";
                mensaje.style.display = "block";
                return;
            }
        }

        // Validar que la hora de entrada no sea despues de la hora de salida
        let diasSwitches = document.querySelectorAll(".switch-dia");

        for (let i = 0; i < diasSwitches.length; i++) {
            let sw = diasSwitches[i];
            let dia = sw.id.replace("switch", "");
            let inputAbre = document.getElementById("abre" + dia);
            let inputCierra = document.getElementById("cierra" + dia);

            if (sw.checked && inputAbre.value != "" && inputCierra.value != "") {
                if (inputAbre.value >= inputCierra.value) {
                    mensaje.innerHTML = "El horario de " + dia + " no es válido, la hora de entrada debe ser antes que la de salida";
                    mensaje.style.backgroundColor = "rgba(149, 24, 24, 0.758)";
                    mensaje.style.display = "block";
                    return;
                }
            }
        }

        mensaje.innerHTML = "Perfil actualizado correctamente";
        mensaje.style.backgroundColor = "rgba(65, 201, 7, 0.8)";
        mensaje.style.display = "block";
        console.log("Perfil actualizado correctamente");

        setTimeout(function () {
            mensaje.style.display = "none";
        }, 5000);
    });

});

// Maximo de donaciones para mostrar
document.addEventListener("DOMContentLoaded", function () {

    let cuerpoTabla = document.getElementById("cuerpoTabla");
    if (!cuerpoTabla) { 
        return;
     }

    let todasLasFilas = cuerpoTabla.querySelectorAll("tr");
    let paginaActual = 1;

    function mostrarPagina(pagina) {
        paginaActual = pagina;

        for (let i = 0; i < todasLasFilas.length; i++) {
            if (i >= 0 && i <= 9 && paginaActual == 1) {
                todasLasFilas[i].style.display = "";
            } else if (i >= 10 && paginaActual == 2) {
                todasLasFilas[i].style.display = "";
            } else {
                todasLasFilas[i].style.display = "none";
            }
        }

        if (paginaActual == 1) {
            document.getElementById("paginacionInfo").innerHTML = "Mostrando 1-10 de " + todasLasFilas.length + " donaciones";
        }
        if (paginaActual == 2) {
            document.getElementById("paginacionInfo").innerHTML = "Mostrando 11-" + todasLasFilas.length + " de " + todasLasFilas.length + " donaciones";
        }
    }

    mostrarPagina(1);

    document.getElementById("btnAnterior").addEventListener("click", function () {
        if (paginaActual > 1) {
            mostrarPagina(paginaActual - 1);
        }
    });

    document.getElementById("btnSiguiente").addEventListener("click", function () {
        if (paginaActual < 2) {
            mostrarPagina(paginaActual + 1);
        }
    });

    document.getElementById("btn1").addEventListener("click", function () {
        mostrarPagina(1);
    });

    document.getElementById("btn2").addEventListener("click", function () {
        mostrarPagina(2);
    });

});