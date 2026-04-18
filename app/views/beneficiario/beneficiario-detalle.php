<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlimenTICO - Detalle de Donación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/sc502-ln-proyecto-grupo4-ln-2026/public/css/beneficiario.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="/sc502-ln-proyecto-grupo4-ln-2026/public/js/beneficiario.js" defer></script>
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
                <a href="index.php?page=beneficiario_panel" class="sidebar-link">Donaciones Disponibles</a>
                <a href="index.php?page=beneficiario_reservas" class="sidebar-link">Mis Reservas</a>
                <a href="index.php?page=beneficiario_perfil" class="sidebar-link">Mi Perfil</a>
                <a href="index.php?page=logout" class="sidebar-link">Cerrar Sesión</a>
            </nav>
        </aside>

        <main class="panel-contenido">

            <?php if (!$donacion): ?>
                <p>Donación no encontrada.</p>
                <a href="index.php?page=beneficiario_panel" class="btn-volver"> Volver</a>
            <?php else: ?>

            <a href="index.php?page=beneficiario_panel" class="btn-volver"> Volver a donaciones</a>

            <div class="formulario-card" style="margin-top: 20px;">
                <div class="row">

                    <div class="col-md-6">
                        <h1 class="titulo-detalle"><?= htmlspecialchars($donacion['nombre_descripcion']) ?></h1>

                        <h5 class="seccion-titulo">INFORMACIÓN DE LA DONACIÓN</h5>

                        <div class="campo">
                            <label class="label-campo">Donado por</label>
                            <input type="text" class="campo-input" value="<?= htmlspecialchars($donacion['nombre_negocio']) ?>" disabled>
                        </div>

                        <div class="campo">
                            <label class="label-campo">Tipo de alimento</label>
                            <input type="text" class="campo-input" value="<?= htmlspecialchars($donacion['tipo_alimento']) ?>" disabled>
                        </div>

                        <div class="campo">
                            <label class="label-campo">Cantidad</label>
                            <input type="text" class="campo-input" value="<?= htmlspecialchars($donacion['cantidad']) ?>" disabled>
                        </div>

                        <div class="campo">
                            <label class="label-campo">Disponible hasta</label>
                            <input type="text" class="campo-input" value="<?= date('d/m/Y', strtotime($donacion['fecha_disponible'])) ?>" disabled>
                        </div>

                        <div class="campo">
                            <label class="label-campo">Hora límite</label>
                            <input type="text" class="campo-input" value="<?= date('g:i A', strtotime($donacion['hora_limite'])) ?>" disabled>
                        </div>

                        <div class="campo">
                            <label class="label-campo">Estado</label>
                            <input type="text" class="campo-input" value="<?= htmlspecialchars($donacion['estado']) ?>" disabled>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h5 class="seccion-titulo">UBICACIÓN</h5>

                        <div class="campo">
                            <label class="label-campo">Provincia / Cantón</label>
                            <input type="text" class="campo-input" value="<?= htmlspecialchars($donacion['provincia']) ?>, <?= htmlspecialchars($donacion['canton']) ?>" disabled>
                        </div>

                        <div class="campo">
                            <label class="label-campo">Dirección</label>
                            <input type="text" class="campo-input" value="<?= htmlspecialchars($donacion['direccion_exacta']) ?>" disabled>
                        </div>

                        <?php if ($donacion['link_maps']): ?>
                        <div class="campo">
                            <label class="label-campo">Google Maps</label>
                            <a href="<?= htmlspecialchars($donacion['link_maps']) ?>" target="_blank" class="btn-accion">Ver en mapa</a>
                        </div>
                        <?php endif; ?>

                        <h5 class="seccion-titulo seccion-titulo-mt">DESCRIPCIÓN</h5>

                        <div class="campo">
                            <label class="label-campo">Descripción del alimento</label>
                            <textarea class="campo-input" rows="3" disabled><?= htmlspecialchars($donacion['descripcion_adicional']) ?></textarea>
                        </div>

                        <div class="campo">
                            <label class="label-campo">Información importante</label>
                            <textarea class="campo-input" rows="2" disabled><?= htmlspecialchars($donacion['informacion_importante']) ?></textarea>
                        </div>

                        <?php if ($donacion['estado'] === 'disponible'): ?>
                        <div class="botones botones-izquierda">
                            <button type="button" class="btn-accion" id="btnReservar"
                                    data-id="<?= $donacion['id_donacion'] ?>">
                                Reservar Donación
                            </button>
                        </div>
                        <?php else: ?>
                        <p class="label-campo" style="color: red;">Esta donación ya no está disponible.</p>
                        <?php endif; ?>

                        <div id="mensaje"></div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

        </main>
    </div>
</body>
</html>