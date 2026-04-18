<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlimentTICO - Recuperar Contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/sc502-ln-proyecto-grupo4-ln-2026/public/css/autentificacion.css">
    <script src="/sc502-ln-proyecto-grupo4-ln-2026/public/js/autentificacion.js" defer></script>
</head>
<body>
    <header>
        <div class="header-logo">
            <img src="/sc502-ln-proyecto-grupo4-ln-2026/public/img/donacion-de-alimentos.png" alt="logo" class="img-logo">
            <span class="logo-texto">Alimen<span class="logo-tico">TICO</span></span>
        </div>
        <nav>
            <a href="/sc502-ln-proyecto-grupo4-ln-2026/index.php?page=inicio">Inicio</a>
            <a href="/sc502-ln-proyecto-grupo4-ln-2026/index.php?page=inicio#nosotros">Sobre Nosotros</a>
        </nav>
        <a href="index.php?page=login" class="btn-header">Iniciar Sesión</a>
    </header>

    <main class="pagina-contenedor">
        <h1 class="titulo-pagina">Recuperar Contraseña</h1>
        <p class="subtitulo-pagina">¿Olvidaste tu contraseña?</p>

        <form id="formRecuperar">
            <div class="formulario-card">
                <h5 class="seccion-titulo">CORREO ELECTRÓNICO</h5>
                <div class="campo">
                    <label for="correo" class="label-campo">Correo Electrónico</label>
                    <input type="text" class="campo-input" id="correo" name="correo">
                </div>

                <div class="botones">
                    <a href="index.php?page=login" class="btn-accion">Cancelar</a>
                    <button type="submit" class="btn-accion" id="btnRecuperar">Recuperar</button>
                </div>

                <div id="mensaje"></div>
                <hr>
                <div class="iniciar-sesion">
                    <label class="label-campo">¿Recordaste tu contraseña?</label>
                    <a href="index.php?page=login" class="iniciar-sesion-link">Iniciar Sesión</a>
                </div>
            </div>
        </form>
    </main>
</body>
</html>