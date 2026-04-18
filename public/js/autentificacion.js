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

// LOGIN

document.addEventListener("DOMContentLoaded", function () {
    var formLogin = document.getElementById("formLogin");
    if (!formLogin) { return; }

    document.getElementById("mensaje").style.display = "none";

    formLogin.addEventListener("submit", function (event) {
        event.preventDefault();

        var correo     = document.getElementById("correo").value.trim();
        var contrasena = document.getElementById("contrasena").value;

        if (correo === "") { mostrarError("El correo electronico es obligatorio" ); return; }
        if (!correo.includes("@") || !correo.includes(".")) { mostrarError("El correo no tiene es valido"); return; }
        if (contrasena === "") { mostrarError("La contraseña es obligatoria"); return; }

        postData({ option: "login", correo: correo, contrasena: contrasena })
            .then(function (data) {
                if (data.response === "00") {
                    mostrarExito("Iniciando sesión ");
                    var rutas = {
                        "admin":        URL_BASE + "?page=admin_panel",
                        "restaurante":  URL_BASE + "?page=restaurante_panel",
                        "beneficiario": URL_BASE + "?page=beneficiario_panel"
                    };
                    setTimeout(function () {
                        window.location.href = rutas[data.rol] || URL_BASE;
                    }, 1200);
                } else {
                    mostrarError(data.message);
                }
            })
            .catch(function () { mostrarError("Error de conexión con el servidor"); });
    });
});

// RECUPERAR CONTRASEÑA

document.addEventListener("DOMContentLoaded", function () {
    var formRecuperar = document.getElementById("formRecuperar");
    if (!formRecuperar) { return; }

    document.getElementById("mensaje").style.display = "none";

    formRecuperar.addEventListener("submit", function (event) {
        event.preventDefault();

        var correo = document.getElementById("correo").value.trim();

        if (correo === "") { mostrarError("El correo electronico es obligatorio"); return; }
        if (!correo.includes("@") || !correo.includes(".")) { mostrarError("El correo no tiene un formato valido"); return; }

        postData({ option: "recuperar_contrasena", correo: correo })
            .then(function (data) {
                if (data.response === "00") {
                    mostrarExito(data.message);
                } else {
                    mostrarError(data.message);
                }
            })
            .catch(function () { mostrarError("Error de conexión"); });
    });
});

// REGISTRO BENEFICIARIO 

document.addEventListener("DOMContentLoaded", function () {
    var formBeneficiario = document.getElementById("formRegistroBeneficiario");
    if (!formBeneficiario) { return; }

    document.getElementById("mensaje").style.display = "none";

    formBeneficiario.addEventListener("submit", function (event) {
        event.preventDefault();

        var nombreCompleto     = document.getElementById("nombreCompleto").value.trim();
        var cedula             = document.getElementById("cedula").value.trim();
        var telefono           = document.getElementById("telefono").value.trim();
        var correo             = document.getElementById("correo").value.trim();
        var contrasena         = document.getElementById("contrasena").value;
        var confirmarContrasena = document.getElementById("confirmarContrasena").value;

        if (nombreCompleto === "")  { mostrarError("El nombre completo es obligatorio"); return; }
        if (cedula === "")          { mostrarError("La cédula de identidad es obligatoria"); return; }
        if (telefono === "")        { mostrarError("El teléfono es obligatorio"); return; }
        if (correo === "")          { mostrarError("El correo electronico es obligatorio"); return; }
        if (!correo.includes("@") || !correo.includes(".")) { mostrarError("El correo no tiene un formato valido"); return; }
        if (contrasena === "")      { mostrarError("La contraseña es obligatoria"); return; }
        if (contrasena.length < 8)  { mostrarError("La contraseña ocupa al menos 8 caracteres"); return; }
        if (contrasena === contrasena.toLowerCase()) { mostrarError("La contraseña ocupa al menos una letra mayuscula"); return; }

        var tieneNumero = false;
        for (var i = 0; i < contrasena.length; i++) {
            if (contrasena[i] >= "0" && contrasena[i] <= "9") { tieneNumero = true; break; }
        }
        if (!tieneNumero)               { mostrarError("La contraseña ocupa al menos un número"); return; }
        if (confirmarContrasena === "")  { mostrarError("Tiene que confirmar tu contraseña"); return; }
        if (contrasena !== confirmarContrasena) { mostrarError("Las contraseñas no son iguales"); return; }

        postData({
            option:           "registro_beneficiario",
            nombreCompleto:   nombreCompleto,
            cedula:           cedula,
            telefono:         telefono,
            correo:           correo,
            contrasena:       contrasena
        })
        .then(function (data) {
            if (data.response === "00") {
                mostrarExito("Registro exitoso, bienvenido a AlimenTICO");
                setTimeout(function () {
                    window.location.href = URL_BASE + "?page=beneficiario_panel";
                }, 2000);
            } else {
                mostrarError(data.message);
            }
        })
        .catch(function () { mostrarError("Error de conexión con el servidor"); });
    });
});

// REGISTRO RESTAURANTE

document.addEventListener("DOMContentLoaded", function () {
    var formRestaurante = document.getElementById("formRegistroRestaurante");
    if (!formRestaurante) { return; }

    document.getElementById("mensaje").style.display = "none";

    // Switches de horario
    var switches = document.querySelectorAll(".switch-dia");
    for (var i = 0; i < switches.length; i++) {
        switches[i].addEventListener("change", function () {
            var dia        = this.id.replace("switch", "");
            var inputAbre  = document.getElementById("abre"   + dia);
            var inputCierra = document.getElementById("cierra" + dia);
            var labelEstado = document.getElementById("estado" + dia);

            if (this.checked) {
                inputAbre.disabled  = false;
                inputCierra.disabled = false;
                labelEstado.innerHTML = "Abierto";
            } else {
                inputAbre.disabled  = true;
                inputAbre.value     = "";
                inputCierra.disabled = true;
                inputCierra.value   = "";
                labelEstado.innerHTML = "Cerrado";
            }
        });
    }

    formRestaurante.addEventListener("submit", function (event) {
        event.preventDefault();

        var nombreNegocio       = document.getElementById("nombreNegocio").value.trim();
        var cedulaJuridica      = document.getElementById("cedulaJuridica").value.trim();
        var telefono            = document.getElementById("telefono").value.trim();
        var canton              = document.getElementById("canton").value.trim();
        var distrito            = document.getElementById("distrito").value.trim();
        var direccion           = document.getElementById("direccion").value.trim();
        var correo              = document.getElementById("correo").value.trim();
        var contrasena          = document.getElementById("contrasena").value;
        var confirmarContrasena  = document.getElementById("confirmarContrasena").value;

        if (nombreNegocio === "")  { mostrarError("El nombre del negocio es obligatorio"); return; }
        if (cedulaJuridica === "") { mostrarError("La cédula jurídica es obligatoria"); return; }
        if (telefono === "")       { mostrarError("El teléfono es obligatorio"); return; }
        if (canton === "")         { mostrarError("El cantón es obligatorio"); return; }
        if (distrito === "")       { mostrarError("El distrito es obligatorio"); return; }
        if (direccion === "")      { mostrarError("La dirección exacta es obligatoria"); return; }
        if (correo === "")         { mostrarError("El correo electronico es obligatorio"); return; }
        if (!correo.includes("@") || !correo.includes(".")) { mostrarError("El correo no tiene un formato valido"); return; }
        if (contrasena === "")     { mostrarError("La contraseña es obligatoria"); return; }
        if (contrasena.length < 8) { mostrarError("La contraseña ocupa al menos 8 caracteres"); return; }
        if (contrasena === contrasena.toLowerCase()) { mostrarError("La contraseña ocupa al menos una letra mayúscula"); return; }

        var tieneNumero = false;
        for (var i = 0; i < contrasena.length; i++) {
            if (contrasena[i] >= "0" && contrasena[i] <= "9") { tieneNumero = true; break; }
        }
        if (!tieneNumero)                { mostrarError("La contraseña ocupa al menos un número"); return; }
        if (confirmarContrasena === "")  { mostrarError("Debes confirmar tu contraseña"); return; }
        if (contrasena !== confirmarContrasena) { mostrarError("Las contraseñas no coinciden"); return; }

        // Validar horarios
        var dias = ["Lunes","Martes","Miercoles","Jueves","Viernes","Sabado","Domingo"];
        for (var d = 0; d < dias.length; d++) {
            var sw      = document.getElementById("switch" + dias[d]);
            var abre    = document.getElementById("abre"   + dias[d]);
            var cierra  = document.getElementById("cierra" + dias[d]);
            if (sw.checked && abre.value !== "" && cierra.value !== "") {
                if (abre.value >= cierra.value) {
                    mostrarError("El horario del " + dias[d] + " no es valido, la apertura debe tiene que ser antes de cerrar");
                    return;
                }
            }
        }

        // Construir body con horarios incluidos
        var body = {
            option:              "registro_restaurante",
            nombreNegocio:       nombreNegocio,
            tipoEstablecimiento: document.getElementById("tipoEstablecimiento").value,
            cedulaJuridica:      cedulaJuridica,
            telefono:            telefono,
            provincia:           document.getElementById("provincia").value,
            canton:              canton,
            distrito:            distrito,
            direccion:           direccion,
            linkMaps:            document.getElementById("googleMaps").value.trim(),
            correo:              correo,
            contrasena:          contrasena
        };

        // Agregar estado de cada switch de horario
        for (var d = 0; d < dias.length; d++) {
            var sw     = document.getElementById("switch" + dias[d]);
            var abre   = document.getElementById("abre"   + dias[d]);
            var cierra = document.getElementById("cierra" + dias[d]);
            if (sw.checked) {
                body["switch" + dias[d]] = "on";
                body["abre"   + dias[d]] = abre.value;
                body["cierra" + dias[d]] = cierra.value;
            }
        }

        postData(body)
            .then(function (data) {
                if (data.response === "00") {
                    mostrarExito("Registro exitoso, bienvenido a AlimenTICO");
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

// NUEVA CONTRASEÑA
document.addEventListener("DOMContentLoaded", function () {
    var formNueva = document.getElementById("formNuevaContrasena");
    if (!formNueva) { return; }

    document.getElementById("mensaje").style.display = "none";

    formNueva.addEventListener("submit", function (event) {
        event.preventDefault();

        var token      = document.getElementById("token").value;
        var contrasena = document.getElementById("nuevaContrasena").value;
        var confirmar  = document.getElementById("confirmarNuevaContrasena").value;

        if (contrasena === "")     { mostrarError("La contraseña es obligatoria"); return; }
        if (contrasena.length < 8) { mostrarError("La contraseña ocupa al menos 8 caracteres"); return; }
        if (contrasena === contrasena.toLowerCase()) { mostrarError("Ocupa al menos una mayúscula"); return; }
        if (contrasena !== confirmar) { mostrarError("Las contraseñas no coinciden"); return; }

        postData({ option: "cambiar_contrasena", token: token, contrasena: contrasena })
            .then(function (data) {
                if (data.response === "00") {
                    mostrarExito("Contraseña actualizada. Redirigiendo...");
                    setTimeout(function () {
                        window.location.href = URL_BASE + "?page=login";
                    }, 2000);
                } else {
                    mostrarError(data.message);
                }
            })
            .catch(function () { mostrarError("Error de conexión"); });
    });
});