<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlimentTICO - Mi Perfil Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="/sc502-ln-proyecto-grupo4-ln-2026/public/css/admin.css">
    <script src="/sc502-ln-proyecto-grupo4-ln-2026/public/js/admin.js" defer></script>
</head>

<body>

    <!-- Boton del sidebar solo para celular -->
    <button class="btn-sidebar" id="btnSidebar">☰</button>

    <div class="layout">

        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-top">
                <h2 class="logo-texto">AlimenTICO <img src="/sc502-ln-proyecto-grupo4-ln-2026/public/img/donacion-de-alimentos.png" alt="logo" height="40px">
                </h2>
                <button class="btn-cerrar-sidebar" id="btnCerrarSidebar">✕</button>
            </div>
            <nav class="sidebar-nav">
                <a href="index.php?page=admin_panel" class="sidebar-link activo">Panel Principal</a>
                <a href="index.php?page=admin_beneficiarios" class="sidebar-link">Beneficiarios</a>
                <a href="index.php?page=admin_restaurantes" class="sidebar-link">Restaurantes</a>
                <a href="index.php?page=admin_perfil" class="sidebar-link">Perfil</a>
                <a href="index.php?page=logout" class="sidebar-link">Cerrar Sesión</a>
            </nav>
        </aside>

        <main class="panel-contenido">

            <h1 class="titulo-panel">MI PERFIL</h1>

            <form method="POST" action="index.php">

            <input type="hidden" name="option" value="guardar_perfil_admin">

            <div class="formulario-card" style="max-width: 550px;">

                <h5 class="seccion-titulo seccion-titulo-mt">DATOS DE ACCESO</h5>

            <div class="campo">
                <label class="label-campo">Correo Electrónico</label>
                <input type="email" class="campo-input" name="correo"
                    value="<?= $datosAdmin['correo'] ?? '' ?>">
            </div>

            <div class="campo">
                <label class="label-campo">Contraseña</label>
                <input type="password" class="campo-input" name="contrasena"
                    placeholder="Dejar vacío para no cambiar">
            </div>

            <div class="botones botones-izquierda" style="margin-top: 20px;">

            <button type="submit" class="btn-accion"
                onclick="eliminarPerfil()">Eliminar Perfil</button>

            <button type="submit" class="btn-accion">
                Guardar Cambios
            </button>

            </div>

    </div>
        </form>

        </main>
    </div>

</body>

</html>