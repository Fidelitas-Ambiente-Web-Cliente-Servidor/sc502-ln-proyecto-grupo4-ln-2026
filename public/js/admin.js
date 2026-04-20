const URL_BASE = "/sc502-ln-proyecto-grupo4-ln-2026/index.php";

document.addEventListener("DOMContentLoaded", function () {

    let formulario = document.querySelector("form");
    let mensaje = document.getElementById("mensaje");

    if (mensaje) {
        mensaje.style.display = "none";
    }
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

// Perfil del Administrador
$(function () {
    let formPerfil = $("#formPerfil");
    if (!formPerfil.length) { return; }

    let mensaje = $("#mensaje");
    mensaje.hide();

    formPerfil.on("submit", function (event) {
        event.preventDefault();

        let correo     = $("#correo").val();
        let contrasena = $("#contrasena").val();

        if (correo == "") { mensaje.html("El correo electrónico es obligatorio").css("background-color", "rgba(149, 24, 24, 0.758)").show(); return; }
        if (!correo.includes("@") || !correo.includes(".")) { mensaje.html("El correo no tiene un formato válido").css("background-color", "rgba(149, 24, 24, 0.758)").show(); return; }

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
                option:     "guardar_perfil_admin",
                correo:     correo,
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

// Filtro
document.addEventListener("DOMContentLoaded", function () {

    const inputBuscar  = document.getElementById("inputBuscar");
    const filtroEstado = document.getElementById("filtroEstado");
    const tabla        = document.getElementById("tablaBeneficiarios");

    if (!inputBuscar || !tabla) return;

    function filtrar() {
        const texto  = inputBuscar.value.toLowerCase();
        const estado = filtroEstado ? filtroEstado.value : "";
        const filas  = tabla.querySelectorAll("tbody tr");

        filas.forEach(fila => {
            const contenido     = fila.textContent.toLowerCase();
            const coincideTexto = contenido.includes(texto);
            const coincideEstado = estado === "" || fila.dataset.estado === estado;

            fila.style.display = (coincideTexto && coincideEstado) ? "" : "none";
        });
    }

    inputBuscar.addEventListener("keyup", filtrar);
    if (filtroEstado) filtroEstado.addEventListener("change", filtrar);
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

// Eliminar beneficiario (admin)
$(document).on("click", ".btn-eliminar-beneficiario", function () {
    let id     = $(this).data("id");
    let nombre = $(this).data("nombre");
    let fila   = $(this).closest("tr");

    if (!confirm('¿Eliminar a "' + nombre + '"? Se cancelarán sus reservas activas y se borrará su cuenta.')) return;

    fetch(URL_BASE, {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: new URLSearchParams({ option: "eliminar_beneficiario", id_beneficiario: id }).toString(),
        credentials: "include"
    })
    .then(r => r.json())
    .then(function (data) {
        let mensaje = $("#mensaje");
        if (data.response === "00") {
            fila.remove();
            mensaje.html(data.message).css("background-color", "rgba(65, 201, 7, 0.8)").show();
            setTimeout(function () { mensaje.hide(); }, 4000);
        } else {
            mensaje.html(data.message).css("background-color", "rgba(149, 24, 24, 0.758)").show();
        }
    })
    .catch(function () { $("#mensaje").html("Error de conexión").show(); });
});

// Eliminar restaurante (admin)
$(document).on("click", ".btn-eliminar-restaurante", function () {
    let id     = $(this).data("id");
    let nombre = $(this).data("nombre");
    let fila   = $(this).closest("tr");

    if (!confirm('¿Eliminar "' + nombre + '"? Se eliminaran sus donaciones, reservas y cuenta.')) return;

    fetch(URL_BASE, {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: new URLSearchParams({ option: "eliminar_restaurante_admin", id_restaurante: id }).toString(),
        credentials: "include"
    })
    .then(r => r.json())
    .then(function (data) {
        let mensaje = $("#mensaje");
        if (data.response === "00") {
            fila.remove();
            mensaje.html(data.message).css("background-color", "rgba(65, 201, 7, 0.8)").show();
            setTimeout(function () { mensaje.hide(); }, 4000);
        } else {
            mensaje.html(data.message).css("background-color", "rgba(149, 24, 24, 0.758)").show();
        }
    })
    .catch(function () { $("#mensaje").html("Error de conexión").show(); });
});