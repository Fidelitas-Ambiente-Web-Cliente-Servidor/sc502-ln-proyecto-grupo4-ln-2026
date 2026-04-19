<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlimenTICO - Panel Principal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
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
            <a href="index.php?page=restaurante_panel" class="sidebar-link activo">Panel Principal</a>
            <a href="index.php?page=restaurante_donaciones" class="sidebar-link">Donaciones</a>
            <a href="index.php?page=restaurante_perfil" class="sidebar-link">Perfil</a>
            <a href="index.php?page=logout" class="sidebar-link">Cerrar Sesión</a>
        </nav>
    </aside>

    <main class="panel-contenido">
        <h1 class="titulo-panel">Resumen de tus donaciones</h1>
        <a href="index.php?page=restaurante_nueva_donacion" class="btn-volver">+ Donar</a>

        <h5 class="seccion-titulo seccion-titulo-mt">ESTADÍSTICAS:</h5>
        <div class="estadisticas">
            <div class="estadistica-card">
                <p>Donaciones Activas</p>
                <strong><?= $estadisticas['disponibles'] ?? 0 ?></strong>
            </div>
            <div class="estadistica-card">
                <p>Donaciones Reservadas</p>
                <strong><?= $estadisticas['reservados'] ?? 0 ?></strong>
            </div>
            <div class="estadistica-card">
                <p>Donaciones Completadas</p>
                <strong><?= $estadisticas['agotados'] ?? 0 ?></strong>
            </div>
            <div class="estadistica-card">
                <p>Total Donaciones</p>
                <strong><?= $estadisticas['total'] ?? 0 ?></strong>
            </div>
        </div>

        <div class="seccion-header">
            <h5 class="seccion-titulo">DONACIONES RECIENTES</h5>
            <a href="index.php?page=restaurante_donaciones" class="btn-volver">Ver todas</a>
        </div>

        <table class="table table-bordered tabla-panel">
            <thead>
                <tr>
                    <th>Alimento</th>
                    <th>Cantidad</th>
                    <th>Fecha</th>
                    <th>Hora Límite</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($donacionesRecientes)): ?>
                    <tr><td colspan="5" class="text-center">No hay donaciones registradas</td></tr>
                <?php else: ?>
                    <?php foreach ($donacionesRecientes as $d): ?>
                        <tr>
                            <td><?= htmlspecialchars($d['nombre_descripcion']) ?></td>
                            <td><?= htmlspecialchars($d['cantidad']) ?></td>
                            <td><?= date('d/m/Y', strtotime($d['fecha_disponible'])) ?></td>
                            <td><?= date('g:i A', strtotime($d['hora_limite'])) ?></td>
                            <td>
                                <?php if ($d['estado'] == 'disponible'): ?>
                                    <span class="badge bg-success">Disponible</span>
                                <?php elseif ($d['estado'] == 'reservado'): ?>
                                    <span class="badge bg-warning">Reservado</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Agotado</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <h5 class="seccion-titulo">ACTIVIDAD RECIENTE:</h5>
        <div class="actividad-lista">
            <?php if (empty($reservasRecientes)): ?>
                <div class="actividad-item">No hay actividad reciente</div>
            <?php else: ?>
                <?php foreach ($reservasRecientes as $r): ?>
                <div class="actividad-item">
                    <i class="bi bi-person"></i> <strong><?= htmlspecialchars($r['nombre_completo']) ?></strong> 
                    reservó "<?= htmlspecialchars($r['nombre_descripcion']) ?>" 
                    - <?= date('d/m/Y H:i', strtotime($r['fecha_reserva'])) ?>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>
</div>
</body>
</html>