console.log("Bienvenidos a AlimentTICO - Beneficiario");

// Sidebar
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

// Perfil del beneficiario
document.addEventListener("DOMContentLoaded", function () {

    let formPerfil = document.getElementById("formPerfil");
    if (!formPerfil) { return; }

    let mensaje = document.getElementById("mensaje");
    mensaje.style.display = "none";

    formPerfil.addEventListener("submit", function (event) {
        event.preventDefault();

        let nombreCompleto = document.getElementById("nombreCompleto");
        let correo = document.getElementById("correo");
        let telefono = document.getElementById("telefono");
        let canton = document.getElementById("canton");
        let direccion = document.getElementById("direccion");
        let identificacion = document.getElementById("identificacion");
        let contrasena = document.getElementById("contrasena");

        if (nombreCompleto.value == "") {
            mensaje.innerHTML = "El nombre completo es obligatorio";
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

        if (direccion.value == "") {
            mensaje.innerHTML = "La dirección exacta es obligatoria";
            mensaje.style.backgroundColor = "rgba(149, 24, 24, 0.758)";
            mensaje.style.display = "block";
            return;
        }

        if (identificacion.value == "") {
            mensaje.innerHTML = "La identificación es obligatoria";
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
                mensaje.innerHTML = "La contraseña debe tener al menos una letra mayúscula";
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

        mensaje.innerHTML = "Perfil actualizado correctamente";
        mensaje.style.backgroundColor = "rgba(65, 201, 7, 0.8)";
        mensaje.style.display = "block";

        setTimeout(function () {
            mensaje.style.display = "none";
        }, 5000);
    });

});

// Detalle de donacion - boton reservar
document.addEventListener("DOMContentLoaded", function () {

    let btnReservar = document.getElementById("btnReservar");
    if (!btnReservar) { return; }

    let mensaje = document.getElementById("mensaje");
    mensaje.style.display = "none";

    btnReservar.addEventListener("click", function () {
        mensaje.innerHTML = "¡Reserva exitosa! Tu código es ALM-2026-001-01. Preséntalo al retirar la donación.";
        mensaje.style.backgroundColor = "rgba(65, 201, 7, 0.8)";
        mensaje.style.display = "block";
    });

});