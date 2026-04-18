<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlimenTICO - Mi Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="/sc502-ln-proyecto-grupo4-ln-2026/public/css/beneficiario.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="/sc502-ln-proyecto-grupo4-ln-2026/public/js/beneficiario.js" defer></script>
</head>

<body>

    <button class="btn-sidebar" id="btnSidebar">☰</button>

    <div class="layout">

        <aside class="sidebar" id="sidebar">
            <div class="sidebar-top">
                <h2 class="logo-texto">AlimenTICO <img
                        src="/sc502-ln-proyecto-grupo4-ln-2026/public/img/donacion-de-alimentos.png" alt="logo"
                        height="40px"></h2>
                <button class="btn-cerrar-sidebar" id="btnCerrarSidebar">✕</button>
            </div>
            <nav class="sidebar-nav">
                <a href="index.php?page=beneficiario_panel" class="sidebar-link">Donaciones Disponibles</a>
                <a href="index.php?page=beneficiario_reservas" class="sidebar-link">Mis Reservas</a>
                <a href="index.php?page=beneficiario_perfil" class="sidebar-link activo">Mi Perfil</a>
                <a href="index.php?page=logout" class="sidebar-link">Cerrar Sesión</a>
            </nav>
        </aside>

        <main class="panel-contenido">

            <h1 class="titulo-panel">MI PERFIL</h1>

            <form id="formPerfil">
                <div class="formulario-card">

                    <h5 class="seccion-titulo">INFORMACIÓN PERSONAL</h5>

                    <div class="campo">
                        <label for="nombreCompleto" class="label-campo">Nombre completo</label>
                        <input type="text" class="campo-input" id="nombreCompleto" name="nombreCompleto"
                            value="<?= htmlspecialchars($beneficiario['nombre_completo'] ?? '') ?>">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="campo">
                                <label for="correo" class="label-campo">Correo electrónico</label>
                                <input type="email" class="campo-input" id="correo" name="correo"
                                    value="<?= htmlspecialchars($_SESSION['correo'] ?? '') ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="campo">
                                <label for="telefono" class="label-campo">Teléfono</label>
                                <input type="tel" class="campo-input" id="telefono" name="telefono"
                                    value="<?= htmlspecialchars($beneficiario['telefono'] ?? '') ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="campo">
                                <label for="provincia" class="label-campo">Provincia</label>
                                <select class="campo-input" id="provincia" name="provincia">
                                    <?php
                                    $provincias = ['San José', 'Alajuela', 'Cartago', 'Heredia', 'Guanacaste', 'Puntarenas', 'Limón'];
                                    foreach ($provincias as $p): ?>
                                        <option value="<?= $p ?>" <?= ($beneficiario['provincia'] ?? '') === $p ? 'selected' : '' ?>>
                                            <?= $p ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="campo">
                                <label for="canton" class="label-campo">Cantón</label>
                                <input type="text" class="campo-input" id="canton" name="canton"
                                    value="<?= htmlspecialchars($beneficiario['canton'] ?? '') ?>">
                            </div>
                        </div>
                    </div>

                    <div class="campo">
                        <label for="direccion" class="label-campo">Dirección exacta</label>
                        <textarea class="campo-input" id="direccion" name="direccion"
                            rows="3"><?= htmlspecialchars($beneficiario['direccion'] ?? '') ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="campo">
                                <label for="identificacion" class="label-campo">Identificación</label>
                                <input type="text" class="campo-input" id="identificacion" name="identificacion"
                                    value="<?= htmlspecialchars($beneficiario['cedula_identidad'] ?? '') ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="campo">
                                <label for="fechaNacimiento" class="label-campo">Fecha de nacimiento</label>
                                <input type="date" class="campo-input" id="fechaNacimiento" name="fechaNacimiento"
                                    value="<?= htmlspecialchars($beneficiario['fecha_nacimiento'] ?? '') ?>">
                            </div>
                        </div>
                    </div>

                    <h5 class="seccion-titulo seccion-titulo-mt">DATOS DE ACCESO</h5>

                    <div class="campo">
                        <label for="contrasena" class="label-campo">Contraseña</label>
                        <input type="password" class="campo-input" id="contrasena" name="contrasena"
                            placeholder="Dejar vacío para no cambiar">
                    </div>

                    <div class="botones botones-izquierda">
                        <button type="button" class="btn-accion" id="btnEliminarPerfil">Eliminar Cuenta</button>
                        <button type="submit" class="btn-accion">Guardar Cambios</button>
                    </div>

                    <div id="mensaje"></div>

                </div>
            </form>

        </main>
    </div>

</body>

</html>