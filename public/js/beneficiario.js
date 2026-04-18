const URL_BASE = "/sc502-ln-proyecto-grupo4-ln-2026/index.php";

console.log("Bienvenidos a AlimentTICO - Beneficiario");

// Sidebar
$(function () {
    let btnSidebar = $("#btnSidebar");
    let btnCerrar = $("#btnCerrarSidebar");
    let sidebar = $("#sidebar");

    if (btnSidebar.length) {
        btnSidebar.on("click", function () {
            sidebar.addClass("abierto");
        });
    }

    if (btnCerrar.length) {
        btnCerrar.on("click", function () {
            sidebar.removeClass("abierto");
        });
    }
});

// Perfil del beneficiario
$(function () {
    let formPerfil = $("#formPerfil");
    if (!formPerfil.length) { return; }

    let mensaje = $("#mensaje");
    mensaje.hide();

    formPerfil.on("submit", function (event) {
        event.preventDefault();

        let nombreCompleto = $("#nombreCompleto").val();
        let correo         = $("#correo").val();
        let telefono       = $("#telefono").val();
        let canton         = $("#canton").val();
        let direccion      = $("#direccion").val();
        let identificacion = $("#identificacion").val();
        let contrasena     = $("#contrasena").val();

        if (nombreCompleto == "") { mensaje.html("El nombre completo es obligatorio").css("background-color", "rgba(149, 24, 24, 0.758)").show(); return; }
        if (correo == "")         { mensaje.html("El correo electrónico es obligatorio").css("background-color", "rgba(149, 24, 24, 0.758)").show(); return; }
        if (!correo.includes("@") || !correo.includes(".")) { mensaje.html("El correo no tiene un formato válido").css("background-color", "rgba(149, 24, 24, 0.758)").show(); return; }
        if (telefono == "")       { mensaje.html("El teléfono es obligatorio").css("background-color", "rgba(149, 24, 24, 0.758)").show(); return; }
        if (canton == "")         { mensaje.html("El cantón es obligatorio").css("background-color", "rgba(149, 24, 24, 0.758)").show(); return; }
        if (direccion == "")      { mensaje.html("La dirección exacta es obligatoria").css("background-color", "rgba(149, 24, 24, 0.758)").show(); return; }
        if (identificacion == "") { mensaje.html("La identificación es obligatoria").css("background-color", "rgba(149, 24, 24, 0.758)").show(); return; }

        if (contrasena != "") {
            if (contrasena.length < 8) { mensaje.html("La contraseña debe tener al menos 8 caracteres").css("background-color", "rgba(149, 24, 24, 0.758)").show(); return; }
            if (contrasena == contrasena.toLowerCase()) { mensaje.html("La contraseña debe tener al menos una letra mayúscula").css("background-color", "rgba(149, 24, 24, 0.758)").show(); return; }

            let tieneNumero = false;
            for (let i = 0; i < contrasena.length; i++) {
                if (contrasena[i] >= "0" && contrasena[i] <= "9") { tieneNumero = true; }
            }
            if (!tieneNumero) { mensaje.html("La contraseña debe tener al menos un número").css("background-color", "rgba(149, 24, 24, 0.758)").show(); return; }
        }

        $.post(URL_BASE,
            {
                option: "guardar_perfil_beneficiario",
                nombreCompleto: nombreCompleto,
                correo: correo,
                telefono: telefono,
                canton: canton,
                direccion: direccion,
                identificacion: identificacion,
                provincia: $("#provincia").val(),
                fechaNacimiento: $("#fechaNacimiento").val(),
                contrasena: contrasena
            },
            function (data) {
                if (data.response == "00") {
                    mensaje.html(data.message).css("background-color", "rgba(65, 201, 7, 0.8)").show();
                } else {
                    mensaje.html(data.message).css("background-color", "rgba(149, 24, 24, 0.758)").show();
                }
            }, "json"
        );
    });
});

// Detalle de donacion - boton reservar
$(function () {
    let btnReservar = $("#btnReservar");
    if (!btnReservar.length) { return; }

    let mensaje = $("#mensaje");
    mensaje.hide();

    btnReservar.on("click", function () {
        let id_donacion = $(this).data("id");

        $.post(URL_BASE,
            { option: "reservar", id_donacion: id_donacion },
            function (data) {
                data = JSON.parse(data);
                if (data.response == "00") {
                    mensaje.html(data.message).css("background-color", "rgba(65, 201, 7, 0.8)").show();
                    btnReservar.prop("disabled", true).html("Reservado");
                } else {
                    mensaje.html(data.message).css("background-color", "rgba(149, 24, 24, 0.758)").show();
                }
            }
        );
    });
});

// Mis reservas - tabs
$(function () {
    let tabActivas = $("#tabActivas");
    if (!tabActivas.length) { return; }

    let tabConfirmadas  = $("#tabConfirmadas");
    let tabCanceladas   = $("#tabCanceladas");
    let seccionActivas  = $("#seccionActivas");
    let seccionConfirmadas = $("#seccionConfirmadas");
    let seccionCanceladas  = $("#seccionCanceladas");
    let mensaje = $("#mensaje");
    mensaje.hide();

    seccionConfirmadas.hide();
    seccionCanceladas.hide();
    tabActivas.addClass("activo");

    tabActivas.on("click", function () {
        seccionActivas.show();
        seccionConfirmadas.hide();
        seccionCanceladas.hide();
        tabActivas.addClass("activo");
        tabConfirmadas.removeClass("activo");
        tabCanceladas.removeClass("activo");
    });

    tabConfirmadas.on("click", function () {
        seccionActivas.hide();
        seccionConfirmadas.show();
        seccionCanceladas.hide();
        tabActivas.removeClass("activo");
        tabConfirmadas.addClass("activo");
        tabCanceladas.removeClass("activo");
    });

    tabCanceladas.on("click", function () {
        seccionActivas.hide();
        seccionConfirmadas.hide();
        seccionCanceladas.show();
        tabActivas.removeClass("activo");
        tabConfirmadas.removeClass("activo");
        tabCanceladas.addClass("activo");
    });

    // Botones confirmar y cancelar
    $(document).on("click", ".btnConfirmar", function () {
        let nombre = $(this).data("nombre");
        let card = $(this).closest(".reserva-card");

        $.post(URL_BASE,
            { option: "confirmar_reserva", id_reserva: $(this).data("id") },
            function (data) {
                if (data.response == "00") {
                    mensaje.html("Retiro de \"" + nombre + "\" confirmado. ¡Gracias por usar AlimenTICO!").css("background-color", "rgba(65, 201, 7, 0.8)").show();
                    card.attr("data-estado", "confirmada");
                    card.find(".reserva-estado").removeClass("estado-activa").addClass("estado-confirmada").html("Confirmada");
                    card.find(".reserva-card-footer").remove();
                    card.appendTo("#seccionConfirmadas");
                } else {
                    mensaje.html(data.message).css("background-color", "rgba(149, 24, 24, 0.758)").show();
                }
            }, "json"
        );
    });

    $(document).on("click", ".btnCancelar", function () {
        let nombre = $(this).data("nombre");
        let card = $(this).closest(".reserva-card");

        $.post(URL_BASE,
            { option: "cancelar_reserva", id_reserva: $(this).data("id") },
            function (data) {
                if (data.response == "00") {
                    mensaje.html("Reserva \"" + nombre + "\" cancelada.").css("background-color", "rgba(149, 24, 24, 0.758)").show();
                    card.attr("data-estado", "cancelada");
                    card.find(".reserva-estado").removeClass("estado-activa").addClass("estado-cancelada").html("Cancelada");
                    card.find(".reserva-card-footer").remove();
                    card.appendTo("#seccionCanceladas");
                } else {
                    mensaje.html(data.message).css("background-color", "rgba(149, 24, 24, 0.758)").show();
                }
            }, "json"
        );
    });
});

// Panel - busqueda, filtros y paginacion
$(function () {
    let grid = $("#donacionesGrid");
    if (!grid.length) { return; }

    let paginaActual = 1;
    let porPagina = 6;

    function getCardsFiltradas() {
        let textoBuscar = $("#inputBuscar").val().toLowerCase().trim();
        let tipoFiltro = $("#filtroTipo").val();
        let provinciaFiltro = $("#filtroProvincia").val();

        let filtradas = [];
        $(".donacion-card").each(function () {
            let nombre = $(this).find(".donacion-nombre").text().toLowerCase();
            let tipo = $(this).data("tipo");
            let provincia = $(this).data("provincia");

            let coincideTexto = textoBuscar === "" || nombre.includes(textoBuscar);
            let coincideTipo = tipoFiltro === "" || tipo === tipoFiltro;
            let coincideProvincia = provinciaFiltro === "" || provincia === provinciaFiltro;

            if (coincideTexto && coincideTipo && coincideProvincia) {
                filtradas.push(this);
            }
        });
        return filtradas;
    }

    function mostrarPagina(pagina) {
        let filtradas    = getCardsFiltradas();
        let totalPaginas = Math.ceil(filtradas.length / porPagina);
        if (totalPaginas === 0) { totalPaginas = 1; }

        $(".donacion-card").hide();

        let desde = (pagina - 1) * porPagina;
        let hasta  = desde + porPagina;
        for (let i = desde; i < hasta && i < filtradas.length; i++) {
            $(filtradas[i]).show();
        }

        let botonesHTML = "<button class='btn-pagina' id='btnAnterior'><i class=' bi bi-arrow-left-square-fill'></i></button>";
        for (let p = 1; p <= totalPaginas; p++) {
            let claseActivo = p === pagina ? " activo" : "";
            botonesHTML += "<button class='btn-pagina" + claseActivo + "' id='btnPagina" + p + "'>" + p + "</button>";
        }
        botonesHTML += "<button class='btn-pagina' id='btnSiguiente'><i class='bi bi-arrow-right-square-fill'></i></button>";
        $("#contenedorBotones").html(botonesHTML);

        $("#btnAnterior").on("click", function () {
            if (paginaActual > 1) { paginaActual--; mostrarPagina(paginaActual); }
        });

        $("#btnSiguiente").on("click", function () {
            if (paginaActual < totalPaginas) { paginaActual++; mostrarPagina(paginaActual); }
        });

        for (let p = 1; p <= totalPaginas; p++) {
            $("#btnPagina" + p).on("click", function () {
                paginaActual = Number($(this).text());
                mostrarPagina(paginaActual);
            });
        }

        $("#paginacionInfo").html("Mostrando " + filtradas.length + " donaciones disponibles");
    }

    $("#inputBuscar").on("input", function () { paginaActual = 1; mostrarPagina(paginaActual); });
    $("#filtroTipo").on("change", function () { paginaActual = 1; mostrarPagina(paginaActual); });
    $("#filtroProvincia").on("change", function () { paginaActual = 1; mostrarPagina(paginaActual); });

    mostrarPagina(1);
});

// Eliminar cuenta
$(function () {
    let btnEliminar = $("#btnEliminarPerfil");
    if (!btnEliminar.length) { return; }

    btnEliminar.on("click", function () {
        if (!confirm("¿Estás seguro de que querés eliminar tu cuenta? Esta acción no se puede deshacer.")) {
            return;
        }

        $.post(URL_BASE,
            { option: "eliminar_cuenta" },
            function (data) {
                if (data.response == "00") {
                    alert("Tu cuenta ha sido eliminada.");
                    window.location.href = "index.php?page=login";
                } else {
                    alert(data.message);
                }
            }, "json"
        );
    });
});