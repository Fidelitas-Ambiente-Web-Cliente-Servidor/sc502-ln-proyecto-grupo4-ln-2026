<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlimentTICO - Iniciar Sesión</title>
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
            <a href="/sc502-ln-proyecto-grupo4-ln-2026/public/index.php">Inicio</a>
            <a href="/sc502-ln-proyecto-grupo4-ln-2026/public/index.php#nosotros">Sobre Nosotros</a>
        </nav>
        <a href="index.php?page=login" class="btn-header">Iniciar Sesión</a>
    </header>

    <main class="pagina-contenedor">
        <h1 class="titulo-pagina">Iniciar Sesión</h1>
        <p class="subtitulo-pagina">Bienvenido de nuevo</p>

        <form id="formLogin">
            <div class="formulario-card">
                <h5 class="seccion-titulo">DATOS DE ACCESO</h5>

                <div class="campo">
                    <label for="correo" class="label-campo">Correo Electrónico</label>
                    <input type="text" class="campo-input" id="correo" name="correo">
                </div>

                <div class="campo">
                    <label for="contrasena" class="label-campo">Contraseña</label>
                    <input type="password" class="campo-input" id="contrasena" name="contrasena">
                </div>

                <a href="index.php?page=recuperar" class="iniciar-sesion-link">¿Olvidaste tu contraseña?</a>

                <div class="botones">
                    <button type="submit" class="btn-accion" id="btnLogin">INGRESAR</button>
                </div>

                <div id="mensaje"></div>
                <hr>
                <div class="iniciar-sesion">
                    <label class="label-campo">¿Eres nuevo?</label>
                    <a href="index.php?page=registro_restaurante" class="iniciar-sesion-link">Registrar Restaurante</a>
                    <a href="index.php?page=registro_beneficiario" class="iniciar-sesion-link">Registrarme como Beneficiario</a>
                </div>
            </div>
        </form>
    </main>
</body>
</html>