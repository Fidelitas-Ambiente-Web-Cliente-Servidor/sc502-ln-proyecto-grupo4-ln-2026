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

// Mis reservas - tabs y botones
document.addEventListener("DOMContentLoaded", function () {

    let tabActivas = document.getElementById("tabActivas");
    if (!tabActivas) { return; }

    let tabConfirmadas = document.getElementById("tabConfirmadas");
    let tabCanceladas = document.getElementById("tabCanceladas");
    let seccionActivas = document.getElementById("seccionActivas");
    let seccionConfirmadas = document.getElementById("seccionConfirmadas");
    let seccionCanceladas = document.getElementById("seccionCanceladas");
    let mensaje = document.getElementById("mensaje");
    mensaje.style.display = "none";

    // Ver las que estan activas primero
    seccionConfirmadas.style.display = "none";
    seccionCanceladas.style.display = "none";
    tabActivas.classList.add("activo");

    tabActivas.addEventListener("click", function () {
        seccionActivas.style.display = "block";
        seccionConfirmadas.style.display = "none";
        seccionCanceladas.style.display = "none";
        tabActivas.classList.add("activo");
        tabConfirmadas.classList.remove("activo");
        tabCanceladas.classList.remove("activo");
    });

    tabConfirmadas.addEventListener("click", function () {
        seccionActivas.style.display = "none";
        seccionConfirmadas.style.display = "block";
        seccionCanceladas.style.display = "none";
        tabActivas.classList.remove("activo");
        tabConfirmadas.classList.add("activo");
        tabCanceladas.classList.remove("activo");
    });

    tabCanceladas.addEventListener("click", function () {
        seccionActivas.style.display = "none";
        seccionConfirmadas.style.display = "none";
        seccionCanceladas.style.display = "block";
        tabActivas.classList.remove("activo");
        tabConfirmadas.classList.remove("activo");
        tabCanceladas.classList.add("activo");
    });

    // Botones para confirmar
    let btnConfirmar1 = document.getElementById("btnConfirmar1");
    let btnConfirmar2 = document.getElementById("btnConfirmar2");

    if (btnConfirmar1) {
        btnConfirmar1.addEventListener("click", function () {
            mensaje.innerHTML = "Retiro de \"Arroz con pollo\" confirmado. ¡Gracias por usar AlimenTICO!";
            mensaje.style.backgroundColor = "rgba(65, 201, 7, 0.8)";
            mensaje.style.display = "block";
        });
    }

    if (btnConfirmar2) {
        btnConfirmar2.addEventListener("click", function () {
            mensaje.innerHTML = "Retiro de \"Ensalada de frutas\" confirmado. ¡Gracias por usar AlimenTICO!";
            mensaje.style.backgroundColor = "rgba(65, 201, 7, 0.8)";
            mensaje.style.display = "block";
        });
    }

    // Botones para cancelar
    let btnCancelar1 = document.getElementById("btnCancelar1");
    let btnCancelar2 = document.getElementById("btnCancelar2");

    if (btnCancelar1) {
        btnCancelar1.addEventListener("click", function () {
            mensaje.innerHTML = "Reserva \"Arroz con pollo\" cancelada.";
            mensaje.style.backgroundColor = "rgba(149, 24, 24, 0.758)";
            mensaje.style.display = "block";
        });
    }

    if (btnCancelar2) {
        btnCancelar2.addEventListener("click", function () {
            mensaje.innerHTML = "Reserva \"Ensalada de frutas\" cancelada.";
            mensaje.style.backgroundColor = "rgba(149, 24, 24, 0.758)";
            mensaje.style.display = "block";
        });
    }

});

// Panel - paginacion del grid de donaciones
document.addEventListener("DOMContentLoaded", function () {

    let grid = document.getElementById("donacionesGrid");
    if (!grid) { return; }

    let todasLasTarjetas = grid.getElementsByClassName("donacion-card");
    let paginaActual = 1;
    let porPagina = 6;
    let totalPaginas = 0;
    let contado = 0;

    for (let i = 0; i < todasLasTarjetas.length; i++) {
        contado = contado + 1;
        if (contado == porPagina) {
            totalPaginas = totalPaginas + 1;
            contado = 0;
        }
    }
    if (contado > 0) {
        totalPaginas = totalPaginas + 1;
    }

    function mostrarPagina(pagina) {
        let desde = (pagina - 1) * porPagina;
        let hasta = desde + porPagina;

        for (let i = 0; i < todasLasTarjetas.length; i++) {
            if (i >= desde && i < hasta) {
                todasLasTarjetas[i].style.display = "flex";
            } else {
                todasLasTarjetas[i].style.display = "none";
            }
        }

        // Botones
        let botonesHTML = "<button class='btn-pagina' id='btnAnterior'><i class='bi bi-arrow-left-square-fill'></i></button>";
        for (let p = 1; p <= totalPaginas; p++) {
            if (p == pagina) {
                botonesHTML += "<button class='btn-pagina activo' id='btnPagina" + p + "'>" + p + "</button>";
            } else {
                botonesHTML += "<button class='btn-pagina' id='btnPagina" + p + "'>" + p + "</button>";
            }
        }
        botonesHTML += "<button class='btn-pagina' id='btnSiguiente'><i class='bi bi-arrow-right-square-fill'></i></button>";
        document.getElementById("contenedorBotones").innerHTML = botonesHTML;

        for (let p = 1; p <= totalPaginas; p++) {
            document.getElementById("btnPagina" + p).addEventListener("click", function () {
                paginaActual = Number(this.innerHTML);
                mostrarPagina(paginaActual);
            });
        }

        document.getElementById("btnAnterior").addEventListener("click", function () {
            if (paginaActual > 1) {
                paginaActual = paginaActual - 1;
                mostrarPagina(paginaActual);
            }
        });

        document.getElementById("btnSiguiente").addEventListener("click", function () {
            if (paginaActual < totalPaginas) {
                paginaActual = paginaActual + 1;
                mostrarPagina(paginaActual);
            }
        });
    }

    mostrarPagina(1);

});