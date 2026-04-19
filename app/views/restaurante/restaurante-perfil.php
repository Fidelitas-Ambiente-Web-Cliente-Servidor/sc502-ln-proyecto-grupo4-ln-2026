<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlimenTICO - Mi Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/sc502-ln-proyecto-grupo4-ln-2026/public/css/restaurante.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="/sc502-ln-proyecto-grupo4-ln-2026/public/js/restaurante.js" defer></script>
</head>
<body>

<button class="btn-sidebar" id="btnSidebar">☰</button>

<div class="layout">
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-top">
            <h2 class="logo-texto">AlimenTICO <img src="/sc502-ln-proyecto-grupo4-ln-2026/public/img/donacion-de-alimentos.png" alt="logo" height="40px"></h2>
            <button class="btn-cerrar-sidebar" id="btnCerrarSidebar">✕</button>
        </div>
        <nav class="sidebar-nav">
            <a href="index.php?page=restaurante_panel" class="sidebar-link">Panel Principal</a>
            <a href="index.php?page=restaurante_donaciones" class="sidebar-link">Donaciones</a>
            <a href="index.php?page=restaurante_perfil" class="sidebar-link activo">Perfil</a>
            <a href="index.php?page=logout" class="sidebar-link">Cerrar Sesión</a>
        </nav>
    </aside>

    <main class="panel-contenido">
        <h1 class="titulo-panel">MI PERFIL</h1>

        <form id="formPerfilRestaurante">
            <div class="formulario-card">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="seccion-titulo">INFORMACIÓN DEL NEGOCIO</h5>

                        <div class="campo">
                            <label for="nombre_negocio" class="label-campo">Nombre del Restaurante/Negocio *</label>
                            <input type="text" class="campo-input" id="nombre_negocio" name="nombre_negocio" value="<?= htmlspecialchars($perfil['nombre_negocio'] ?? '') ?>" required>
                        </div>

                        <div class="campo">
                            <label for="tipo_establecimiento" class="label-campo">Tipo de Establecimiento</label>
                            <select class="campo-input" id="tipo_establecimiento" name="tipo_establecimiento">
                                <option value="Restaurante" <?= ($perfil['tipo_establecimiento'] ?? '') == 'Restaurante' ? 'selected' : '' ?>>Restaurante</option>
                                <option value="Panadería" <?= ($perfil['tipo_establecimiento'] ?? '') == 'Panadería' ? 'selected' : '' ?>>Panadería</option>
                                <option value="Cafetería" <?= ($perfil['tipo_establecimiento'] ?? '') == 'Cafetería' ? 'selected' : '' ?>>Cafetería</option>
                                <option value="Sodas" <?= ($perfil['tipo_establecimiento'] ?? '') == 'Sodas' ? 'selected' : '' ?>>Sodas</option>
                                <option value="Supermercado" <?= ($perfil['tipo_establecimiento'] ?? '') == 'Supermercado' ? 'selected' : '' ?>>Supermercado</option>
                                <option value="Otro" <?= ($perfil['tipo_establecimiento'] ?? '') == 'Otro' ? 'selected' : '' ?>>Otro</option>
                            </select>
                        </div>

                        <div class="campo">
                            <label for="cedula_juridica" class="label-campo">Cédula Jurídica *</label>
                            <input type="text" class="campo-input" id="cedula_juridica" name="cedula_juridica" value="<?= htmlspecialchars($perfil['cedula_juridica'] ?? '') ?>" required>
                        </div>

                        <div class="campo">
                            <label for="telefono" class="label-campo">Teléfono del Negocio *</label>
                            <input type="text" class="campo-input" id="telefono" name="telefono" value="<?= htmlspecialchars($perfil['telefono'] ?? '') ?>" required>
                        </div>

                        <h5 class="seccion-titulo seccion-titulo-mt">HORARIO DE OPERACIÓN</h5>

                        <?php
                        $dias = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'];
                        $nombresDias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
                        for ($i = 0; $i < count($dias); $i++):
                            $dia = $dias[$i];
                            $nombre = $nombresDias[$i];
                            $horario = $horariosPorDia[$dia] ?? null;
                            $activo = $horario && $horario['activo'];
                            $abre = $horario ? $horario['hora_apertura'] : '';
                            $cierra = $horario ? $horario['hora_cierre'] : '';
                        ?>
                        <div class="campo fila-horario">
                            <div class="fila-horario-top">
                                <span class="dia-label"><?= $nombre ?>:</span>
                                <div class="form-check form-switch">
                                    <input class="form-check-input switch-dia" type="checkbox" id="switch<?= ucfirst($dia) ?>" <?= $activo ? 'checked' : '' ?>>
                                    <label class="form-check-label label-estado" for="switch<?= ucfirst($dia) ?>" id="estado<?= ucfirst($dia) ?>"><?= $activo ? 'Abierto' : 'Cerrado' ?></label>
                                </div>
                            </div>
                            <div class="fila-horario-horas">
                                <input type="time" class="campo-input input-hora" id="abre<?= ucfirst($dia) ?>" name="abre<?= ucfirst($dia) ?>" value="<?= $abre ?>" <?= !$activo ? 'disabled' : '' ?>>
                                <span class="label-campo">a</span>
                                <input type="time" class="campo-input input-hora" id="cierra<?= ucfirst($dia) ?>" name="cierra<?= ucfirst($dia) ?>" value="<?= $cierra ?>" <?= !$activo ? 'disabled' : '' ?>>
                            </div>
                        </div>
                        <?php endfor; ?>
                    </div>

                    <div class="col-md-6">
                        <h5 class="seccion-titulo">UBICACIÓN</h5>

                        <div class="campo">
                            <label for="provincia" class="label-campo">Provincia</label>
                            <select class="campo-input" id="provincia" name="provincia">
                                <option value="San José" <?= ($perfil['provincia'] ?? '') == 'San José' ? 'selected' : '' ?>>San José</option>
                                <option value="Alajuela" <?= ($perfil['provincia'] ?? '') == 'Alajuela' ? 'selected' : '' ?>>Alajuela</option>
                                <option value="Cartago" <?= ($perfil['provincia'] ?? '') == 'Cartago' ? 'selected' : '' ?>>Cartago</option>
                                <option value="Heredia" <?= ($perfil['provincia'] ?? '') == 'Heredia' ? 'selected' : '' ?>>Heredia</option>
                                <option value="Guanacaste" <?= ($perfil['provincia'] ?? '') == 'Guanacaste' ? 'selected' : '' ?>>Guanacaste</option>
                                <option value="Puntarenas" <?= ($perfil['provincia'] ?? '') == 'Puntarenas' ? 'selected' : '' ?>>Puntarenas</option>
                                <option value="Limón" <?= ($perfil['provincia'] ?? '') == 'Limón' ? 'selected' : '' ?>>Limón</option>
                            </select>
                        </div>

                        <div class="campo">
                            <label for="canton" class="label-campo">Cantón *</label>
                            <input type="text" class="campo-input" id="canton" name="canton" value="<?= htmlspecialchars($perfil['canton'] ?? '') ?>" required>
                        </div>

                        <div class="campo">
                            <label for="distrito" class="label-campo">Distrito *</label>
                            <input type="text" class="campo-input" id="distrito" name="distrito" value="<?= htmlspecialchars($perfil['distrito'] ?? '') ?>" required>
                        </div>

                        <div class="campo">
                            <label for="direccion_exacta" class="label-campo">Dirección Exacta *</label>
                            <textarea class="campo-input" id="direccion_exacta" name="direccion_exacta" rows="3" required><?= htmlspecialchars($perfil['direccion_exacta'] ?? '') ?></textarea>
                        </div>

                        <div class="campo">
                            <label for="link_maps" class="label-campo">Link de Google Maps</label>
                            <input type="text" class="campo-input" id="link_maps" name="link_maps" value="<?= htmlspecialchars($perfil['link_maps'] ?? '') ?>">
                        </div>

                        <h5 class="seccion-titulo seccion-titulo-mt">DATOS DE ACCESO</h5>

                        <div class="campo">
                            <label for="correo" class="label-campo">Correo Electrónico</label>
                            <input type="email" class="campo-input" id="correo" name="correo" value="<?= htmlspecialchars($perfil['correo'] ?? '') ?>">
                        </div>

                        <div class="campo">
                            <label for="contrasena" class="label-campo">Nueva Contraseña</label>
                            <input type="password" class="campo-input" id="contrasena" name="contrasena" placeholder="Dejar vacío para no cambiar">
                        </div>

                        <div class="botones botones-izquierda">
                            <button type="button" class="btn-accion" id="btnEliminarPerfil">Eliminar Cuenta</button>
                            <button type="submit" class="btn-accion">Guardar Cambios</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div id="mensaje" style="display:none;"></div>
    </main>
</div>
</body>
</html>