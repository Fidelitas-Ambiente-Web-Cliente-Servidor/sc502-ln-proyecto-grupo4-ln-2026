<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlimentTICO - Registro Beneficiario</title>
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

    <main class="pagina-contenedor-ancho">
        <h1 class="titulo-pagina">FORMULARIO DE REGISTRO</h1>
        <p class="subtitulo-pagina">Registro de Beneficiario, accede a alimentos disponibles cerca de ti</p>

        <form id="formRegistroBeneficiario">
            <div class="formulario-card">
                <div class="row">

                    <div class="col-md-6">
                        <h5 class="seccion-titulo">INFORMACIÓN PERSONAL</h5>

                        <div class="campo">
                            <label for="nombreCompleto" class="label-campo">Nombre Completo</label>
                            <input type="text" class="campo-input" id="nombreCompleto" name="nombreCompleto" placeholder="Ej: Juan Gutierrez Gomez">
                        </div>

                        <div class="campo">
                            <label for="cedula" class="label-campo">Cédula de identidad</label>
                            <input type="text" class="campo-input" id="cedula" name="cedula" placeholder="Ej: 118181818">
                        </div>

                        <div class="campo">
                            <label for="telefono" class="label-campo">Teléfono</label>
                            <input type="text" class="campo-input" id="telefono" name="telefono" placeholder="Ej: 88888888">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h5 class="seccion-titulo">DATOS DE ACCESO</h5>

                        <div class="campo">
                            <label for="correo" class="label-campo">Correo Electrónico</label>
                            <input type="text" class="campo-input" id="correo" name="correo">
                        </div>

                        <div class="campo">
                            <label for="contrasena" class="label-campo">Contraseña</label>
                            <input type="password" class="campo-input" id="contrasena" name="contrasena">
                        </div>

                        <div class="campo">
                            <label for="confirmarContrasena" class="label-campo">Confirmar Contraseña</label>
                            <input type="password" class="campo-input" id="confirmarContrasena" name="confirmarContrasena">
                        </div>
                    </div>
                </div>
                <div class="botones">
                    <button type="submit" class="btn-accion" id="btnRegistrar">REGISTRAR</button>
                </div>

                <div id="mensaje"></div>
                <hr>
                <div class="iniciar-sesion">
                    <label class="label-campo">¿Ya tienes cuenta?</label>
                    <a href="index.php?page=login" class="iniciar-sesion-link">Iniciar Sesión</a>
                </div>
            </div>
        </form>
    </main>
</body>
</html>