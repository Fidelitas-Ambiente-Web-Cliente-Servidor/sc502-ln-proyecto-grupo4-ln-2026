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