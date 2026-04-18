<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlimentTICO - Mis Reservas</title>
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
                <h2 class="logo-texto">AlimenTICO <img src="/sc502-ln-proyecto-grupo4-ln-2026/public/img/donacion-de-alimentos.png" alt="logo" height="40px"></h2>
                <button class="btn-cerrar-sidebar" id="btnCerrarSidebar">✕</button>
            </div>
            <nav class="sidebar-nav">
                <a href="index.php?page=beneficiario_panel" class="sidebar-link activo">Donaciones Disponibles</a>
                <a href="index.php?page=beneficiario_reservas" class="sidebar-link">Mis Reservas</a>
                <a href="index.php?page=beneficiario_perfil" class="sidebar-link">Mi Perfil</a>
                <a href="index.php?page=logout" class="sidebar-link">Cerrar Sesión</a>
            </nav>
        </aside>

        <main class="panel-contenido">

            <h1 class="titulo-panel">Mis Reservas</h1>

            <div id="mensaje"></div>

            <div class="tabs-reservas">
                <button class="tab-reserva" id="tabActivas">Activas</button>
                <button class="tab-reserva" id="tabConfirmadas">Confirmadas</button>
                <button class="tab-reserva" id="tabCanceladas">Canceladas</button>
            </div>

            <div id="seccionActivas">
                <?php if (empty($activas)): ?>
                    <p class="label-campo">No tenés reservas activas.</p>
                <?php else: ?>
                    <?php foreach ($activas as $r): ?>
                        <div class="reserva-card" data-estado="activa">
                            <div class="reserva-card-header">
                                <div>
                                    <h5 class="reserva-nombre"><?= htmlspecialchars($r['nombre_descripcion']) ?></h5>
                                    <span class="reserva-estado estado-activa">Pendiente</span>
                                </div>
                                <span class="reserva-codigo"><?= htmlspecialchars($r['codigo_reserva']) ?></span>
                            </div>
                            <div class="reserva-card-body">
                                <div class="reserva-campo">
                                    <span class="reserva-label">Negocio</span>
                                    <span><?= htmlspecialchars($r['nombre_negocio']) ?></span>
                                </div>
                                <div class="reserva-campo">
                                    <span class="reserva-label">Fecha</span>
                                    <span><?= date('d/m/Y', strtotime($r['fecha_disponible'])) ?></span>
                                </div>
                                <div class="reserva-campo">
                                    <span class="reserva-label">Hora límite</span>
                                    <span><?= date('g:i A', strtotime($r['hora_limite'])) ?></span>
                                </div>
                                <div class="reserva-campo">
                                    <span class="reserva-label">Ubicación</span>
                                    <span><?= htmlspecialchars($r['provincia']) ?>, <?= htmlspecialchars($r['canton']) ?></span>
                                </div>
                            </div>
                            <div class="reserva-card-footer">
                                <button class="btn-accion btnConfirmar" data-id="<?= $r['id_reserva'] ?>"
                                    data-nombre="<?= htmlspecialchars($r['nombre_descripcion']) ?>">
                                    Confirmar retiro
                                </button>
                                <button class="btn-accion btnCancelar" data-id="<?= $r['id_reserva'] ?>"
                                    data-nombre="<?= htmlspecialchars($r['nombre_descripcion']) ?>">
                                    Cancelar reserva
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div id="seccionConfirmadas">
                <?php if (empty($confirmadas)): ?>
                    <p class="label-campo">No tenés reservas confirmadas.</p>
                <?php else: ?>
                    <?php foreach ($confirmadas as $r): ?>
                        <div class="reserva-card" data-estado="confirmada">
                            <div class="reserva-card-header">
                                <div>
                                    <h5 class="reserva-nombre"><?= htmlspecialchars($r['nombre_descripcion']) ?></h5>
                                    <span class="reserva-estado estado-confirmada">Confirmada</span>
                                </div>
                                <span class="reserva-codigo"><?= htmlspecialchars($r['codigo_reserva']) ?></span>
                            </div>
                            <div class="reserva-card-body">
                                <div class="reserva-campo">
                                    <span class="reserva-label">Negocio</span>
                                    <span><?= htmlspecialchars($r['nombre_negocio']) ?></span>
                                </div>
                                <div class="reserva-campo">
                                    <span class="reserva-label">Fecha</span>
                                    <span><?= date('d/m/Y', strtotime($r['fecha_disponible'])) ?></span>
                                </div>
                                <div class="reserva-campo">
                                    <span class="reserva-label">Ubicación</span>
                                    <span><?= htmlspecialchars($r['provincia']) ?>, <?= htmlspecialchars($r['canton']) ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div id="seccionCanceladas">
                <?php if (empty($canceladas)): ?>
                    <p class="label-campo">No tenés reservas canceladas.</p>
                <?php else: ?>
                    <?php foreach ($canceladas as $r): ?>
                        <div class="reserva-card" data-estado="cancelada">
                            <div class="reserva-card-header">
                                <div>
                                    <h5 class="reserva-nombre"><?= htmlspecialchars($r['nombre_descripcion']) ?></h5>
                                    <span class="reserva-estado estado-cancelada">Cancelada</span>
                                </div>
                                <span class="reserva-codigo"><?= htmlspecialchars($r['codigo_reserva']) ?></span>
                            </div>
                            <div class="reserva-card-body">
                                <div class="reserva-campo">
                                    <span class="reserva-label">Negocio</span>
                                    <span><?= htmlspecialchars($r['nombre_negocio']) ?></span>
                                </div>
                                <div class="reserva-campo">
                                    <span class="reserva-label">Fecha</span>
                                    <span><?= date('d/m/Y', strtotime($r['fecha_disponible'])) ?></span>
                                </div>
                                <div class="reserva-campo">
                                    <span class="reserva-label">Ubicación</span>
                                    <span><?= htmlspecialchars($r['provincia']) ?>, <?= htmlspecialchars($r['canton']) ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

        </main>
    </div>

</body>

</html>