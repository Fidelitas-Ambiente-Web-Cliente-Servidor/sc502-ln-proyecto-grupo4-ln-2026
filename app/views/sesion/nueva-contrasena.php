<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>AlimentTICO - Nueva Contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/sc502-ln-proyecto-grupo4-ln-2026/public/css/autentificacion.css">
    <script src="/sc502-ln-proyecto-grupo4-ln-2026/public/js/autentificacion.js" defer></script>
</head>
<body>
    <header>
        <div class="header-logo">
            <span class="logo-texto">Alimen<span class="logo-tico">TICO</span></span>
        </div>
    </header>

    <main class="pagina-contenedor">
        <h1 class="titulo-pagina">Nueva Contraseña</h1>
        <p class="subtitulo-pagina">Ingrese su nueva contraseña</p>

        <form id="formNuevaContrasena">
            <!-- Aqui se pasa el token oculto -->
            <input type="hidden" id="token" value="<?= htmlspecialchars($_GET['token'] ?? '') ?>">

            <div class="formulario-card">
                <div class="campo">
                    <label class="label-campo">Nueva Contraseña</label>
                    <input type="password" class="campo-input" id="nuevaContrasena">
                </div>
                <div class="campo">
                    <label class="label-campo">Confirmar Contraseña</label>
                    <input type="password" class="campo-input" id="confirmarNuevaContrasena">
                </div>

                <div class="botones">
                    <button type="submit" class="btn-accion">Guardar</button>
                </div>
                <div id="mensaje"></div>
            </div>
        </form>
    </main>
</body>
</html>