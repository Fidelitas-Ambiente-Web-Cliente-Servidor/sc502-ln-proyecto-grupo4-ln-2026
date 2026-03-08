// login
document.addEventListener("DOMContentLoaded", function () {

    var formLogin = document.getElementById("formLogin");
    if (!formLogin) { return; }

    var mensaje = document.getElementById("mensaje");
    mensaje.style.display = "none";

    formLogin.addEventListener("submit", function (event) {
        event.preventDefault();

        var correo = document.getElementById("correo");
        var contrasena = document.getElementById("contrasena");

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

        if (contrasena.value == "") {
            mensaje.innerHTML = "La contraseña es obligatoria";
            mensaje.style.backgroundColor = "rgba(149, 24, 24, 0.758)";
            mensaje.style.display = "block";
            return;
        }

        mensaje.innerHTML = "Iniciando sesión...";
        mensaje.style.backgroundColor = "rgba(65, 201, 7, 0.8)";
        mensaje.style.display = "block";
        console.log("Login correcto");

        setTimeout(function () {
            window.location.href = "admin-panel.html";
        }, 1500);
    });
});

//recuperar la contraseña
document.addEventListener("DOMContentLoaded", function () {

    var formRecuperar = document.getElementById("formRecuperar");
    if (!formRecuperar) { return; }

    var mensaje = document.getElementById("mensaje");
    mensaje.style.display = "none";

    formRecuperar.addEventListener("submit", function (event) {
        event.preventDefault();

        var correo = document.getElementById("correo");

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

        mensaje.innerHTML = "Se envió un correo de recuperación a " + correo.value;
        mensaje.style.backgroundColor = "rgba(65, 201, 7, 0.8)";
        mensaje.style.display = "block";
        console.log("Correo de recuperación enviado");
    });
});

// registro del beneficiario
document.addEventListener("DOMContentLoaded", function () {

    var formBeneficiario = document.getElementById("formRegistroBeneficiario");
    if (!formBeneficiario) { return; }

    var mensaje = document.getElementById("mensaje");
    mensaje.style.display = "none";

    formBeneficiario.addEventListener("submit", function (event) {
        event.preventDefault();

        var nombreCompleto = document.getElementById("nombreCompleto");
        var cedula = document.getElementById("cedula");
        var telefono = document.getElementById("telefono");
        var correo = document.getElementById("correo");
        var contrasena = document.getElementById("contrasena");
        var confirmarContrasena = document.getElementById("confirmarContrasena");

        if (nombreCompleto.value == "") {
            mensaje.innerHTML = "El nombre completo es obligatorio";
            mensaje.style.backgroundColor = "rgba(149, 24, 24, 0.758)";
            mensaje.style.display = "block";
            return;
        }

        if (cedula.value == "") {
            mensaje.innerHTML = "La cédula de identidad es obligatoria";
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

        if (contrasena.value == "") {
            mensaje.innerHTML = "La contraseña es obligatoria";
            mensaje.style.backgroundColor = "rgba(149, 24, 24, 0.758)";
            mensaje.style.display = "block";
            return;
        }

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

        var tieneNumero = false;
        for (var i = 0; i < contrasena.value.length; i++) {
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

        if (confirmarContrasena.value == "") {
            mensaje.innerHTML = "Debes confirmar tu contraseña";
            mensaje.style.backgroundColor = "rgba(149, 24, 24, 0.758)";
            mensaje.style.display = "block";
            return;
        }

        if (contrasena.value != confirmarContrasena.value) {
            mensaje.innerHTML = "Las contraseñas no coinciden";
            mensaje.style.backgroundColor = "rgba(149, 24, 24, 0.758)";
            mensaje.style.display = "block";
            return;
        }

        mensaje.innerHTML = "Registro exitoso, bienvenido a AlimentTICO";
        mensaje.style.backgroundColor = "rgba(65, 201, 7, 0.8)";
        mensaje.style.display = "block";
        console.log("Registro beneficiario correcto");

        setTimeout(function () {
            window.location.href = "beneficiario-panel.html";
        }, 2000);
    });
});

// registro del restaurante
document.addEventListener("DOMContentLoaded", function () {

    var formRestaurante = document.getElementById("formRegistroRestaurante");
    if (!formRestaurante) { return; }

    var mensaje = document.getElementById("mensaje");
    mensaje.style.display = "none";

    // Switches de horario
    var switches = document.querySelectorAll(".switch-dia");
    for (var i = 0; i < switches.length; i++) {
        var sw = switches[i];
        sw.addEventListener("change", function () {
            var dia = this.id.replace("switch", "");
            var inputAbre = document.getElementById("abre" + dia);
            var inputCierra = document.getElementById("cierra" + dia);
            var labelEstado = document.getElementById("estado" + dia);

            if (this.checked) {
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

    formRestaurante.addEventListener("submit", function (event) {
        event.preventDefault();

        var nombreNegocio = document.getElementById("nombreNegocio");
        var cedulaJuridica = document.getElementById("cedulaJuridica");
        var telefono = document.getElementById("telefono");
        var canton = document.getElementById("canton");
        var distrito = document.getElementById("distrito");
        var direccion = document.getElementById("direccion");
        var correo = document.getElementById("correo");
        var contrasena = document.getElementById("contrasena");
        var confirmarContrasena = document.getElementById("confirmarContrasena");

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

        if (contrasena.value == "") {
            mensaje.innerHTML = "La contraseña es obligatoria";
            mensaje.style.backgroundColor = "rgba(149, 24, 24, 0.758)";
            mensaje.style.display = "block";
            return;
        }

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

        var tieneNumero = false;
        for (var i = 0; i < contrasena.value.length; i++) {
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

        if (confirmarContrasena.value == "") {
            mensaje.innerHTML = "Debes confirmar tu contraseña";
            mensaje.style.backgroundColor = "rgba(149, 24, 24, 0.758)";
            mensaje.style.display = "block";
            return;
        }

        if (contrasena.value != confirmarContrasena.value) {
            mensaje.innerHTML = "Las contraseñas no coinciden";
            mensaje.style.backgroundColor = "rgba(149, 24, 24, 0.758)";
            mensaje.style.display = "block";
            return;
        }

        // Validar horarios: hora de entrada no puede ser después de hora de salida
        var diasSwitches = document.querySelectorAll(".switch-dia");
        for (var i = 0; i < diasSwitches.length; i++) {
            var swVal = diasSwitches[i];
            var dia = swVal.id.replace("switch", "");
            var inputAbre = document.getElementById("abre" + dia);
            var inputCierra = document.getElementById("cierra" + dia);

            if (swVal.checked && inputAbre.value != "" && inputCierra.value != "") {
                if (inputAbre.value >= inputCierra.value) {
                    mensaje.innerHTML = "El horario del " + dia + " no es válido, la hora de apertura debe ser antes que la de cierre";
                    mensaje.style.backgroundColor = "rgba(149, 24, 24, 0.758)";
                    mensaje.style.display = "block";
                    return;
                }
            }
        }

        mensaje.innerHTML = "Registro exitoso, bienvenido a AlimentTICO";
        mensaje.style.backgroundColor = "rgba(65, 201, 7, 0.8)";
        mensaje.style.display = "block";
        console.log("Registro restaurante correcto");

        setTimeout(function () {
            window.location.href = "restaurante-panel.html";
        }, 2000);
    });
});