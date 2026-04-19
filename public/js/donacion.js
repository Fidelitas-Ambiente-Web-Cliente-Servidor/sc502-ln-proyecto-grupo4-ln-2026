const URL_BASE = "/sc502-ln-proyecto-grupo4-ln-2026/index.php";

// Helpers

function mostrarError(mensaje) {
    var el = document.getElementById("mensaje");
    el.innerHTML = mensaje;
    el.style.backgroundColor = "rgba(149, 24, 24, 0.758)";
    el.style.display = "block";
}

function mostrarExito(mensaje) {
    var el = document.getElementById("mensaje");
    el.innerHTML = mensaje;
    el.style.backgroundColor = "rgba(65, 201, 7, 0.8)";
    el.style.display = "block";
}

function postData(body) {
    return fetch(URL_BASE, {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: new URLSearchParams(body).toString()
    }).then(function (r) { return r.json(); });
}


// NUEVA DONACION  

document.addEventListener("DOMContentLoaded", function () {
    var formDonacion = document.getElementById("nuevaDonacion");
    if (!formDonacion) { return; }

    document.getElementById("mensaje").style.display = "none";

    formDonacion.addEventListener("submit", function (event) {
        event.preventDefault();

        var tipoAlimento     = document.getElementById("tipoAlimento").value;
        var nombreDescripcion             = document.getElementById("nombreDescripcion").value.trim();
        var cantidad           = document.getElementById("cantidad").value.trim();
        var descripcionAdicional             = document.getElementById("descripcionAdicional").value.trim();
        var estado         = document.getElementById("estado").value;
        var fechaDisponible = document.getElementById("fechaDisponible").value;
        var horaLimite = document.getElementById("horaLimite").value;
        var informacionImportante = document.getElementById("informacionImportante").value;
        var fechaVar = new Date(fechaDisponible); 
        var hoy = new Date();
        hoy.setHours(0, 0, 0, 0);
        if (tipoAlimento === "")  { mostrarError("El tipo de alimento es obligatorio"); return; }
        if (nombreDescripcion === "")          { mostrarError("El nombre es obligatorio"); return; }
        if (cantidad === "")        { mostrarError("La cantidad es obligatoria"); return; }
        if (estado === "")      { mostrarError("El estado es obligatorio"); return; }
        if (fechaDisponible === "")      { mostrarError("La fecha de disponibilidad es obligatoria"); return; }
        if (horaLimite === "")      { mostrarError("La hora limite es obligatoria"); return; }
        if(fechaVar < hoy)   { mostrarError("La fecha de disponible debe ser mayor a hoy"); return; }



        postData({
            option:           "nueva-donacion",
            tipoAlimento:   tipoAlimento,
            nombreDescripcion: nombreDescripcion,
            cantidad: cantidad,
            descripcionAdicional: descripcionAdicional,
            estado: estado,
            fechaDisponible: fechaDisponible,
            horaLimite: horaLimite,
            informacionImportante: informacionImportante
        })
        .then(function (data) {
            if (data.response === "00") {
                mostrarExito("Ingreso de donacion exitoso");
                setTimeout(function () {
                    window.location.href = URL_BASE + "?page=restaurante_panel";
                }, 2000);
            } else {
                mostrarError(data.message);
            }
        })
        .catch(function () { mostrarError("Error de conexión con el servidor"); });
    });
});

