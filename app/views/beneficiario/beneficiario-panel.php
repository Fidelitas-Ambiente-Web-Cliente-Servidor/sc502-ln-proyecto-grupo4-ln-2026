<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlimentTICO - Donaciones Disponibles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
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
            <h1 class="titulo-panel">Donaciones Disponibles</h1>

            <div class="donaciones-filtros">
                <div class="donaciones-buscar">
                    <label class="label-campo">Buscar:</label>
                    <div class="buscar-input-contenedor">
                        <input type="text" class="campo-input buscar-input" id="inputBuscar" placeholder="Buscar donación...">
                        <span class="buscar-icono"><i class="bi bi-search"></i></span>
                    </div>
                </div>
                <div class="donaciones-filtrar">
                    <label class="label-campo">Filtrar:</label>
                    <div>
                        <select class="campo-input filtro-select" id="filtroTipo">
                            <option value="">Tipo de alimento</option>
                            <option value="Comida Preparada">Comida Preparada</option>
                            <option value="Panaderia">Panadería</option>
                            <option value="Frutas">Frutas</option>
                            <option value="Verduras">Verduras</option>
                            <option value="Lacteos">Lácteos</option>
                            <option value="Otro">Otro</option>
                        </select>
                        <select class="campo-input filtro-select" id="filtroProvincia">
                            <option value="">Provincia</option>
                            <option value="San José">San José</option>
                            <option value="Alajuela">Alajuela</option>
                            <option value="Heredia">Heredia</option>
                            <option value="Cartago">Cartago</option>
                            <option value="Guanacaste">Guanacaste</option>
                            <option value="Puntarenas">Puntarenas</option>
                            <option value="Limón">Limón</option>
                        </select>
                    </div>
                </div>
            </div>

            <h5 class="seccion-titulo">PUBLICACIONES DISPONIBLES:</h5>

            <div class="donaciones-grid" id="donacionesGrid">

                <?php if (empty($donaciones)): ?>
                    <p class="label-campo">No hay donaciones disponibles por el momento.</p>
                <?php else: ?>
                    <?php foreach ($donaciones as $d): ?>
                    <div class="donacion-card"
                         data-tipo="<?= htmlspecialchars($d['tipo_alimento']) ?>"
                         data-provincia="<?= htmlspecialchars($d['provincia']) ?>">
                        <div class="card-content">
                            <h5 class="donacion-nombre"><?= htmlspecialchars($d['nombre_descripcion']) ?></h5>
                            <p class="donacion-info"><i class="bi bi-shop"></i> <?= htmlspecialchars($d['nombre_negocio']) ?></p>
                            <p class="donacion-info"><i class="bi bi-geo-alt"></i> <?= htmlspecialchars($d['provincia']) ?>, <?= htmlspecialchars($d['canton']) ?></p>
                            <p class="donacion-info"><i class="bi bi-clock"></i> Hasta: <?= date('g:i A', strtotime($d['hora_limite'])) ?> | <?= date('d/m/Y', strtotime($d['fecha_disponible'])) ?></p>
                            <p class="donacion-desc"><?= htmlspecialchars($d['descripcion_adicional']) ?></p>
                            <div class="donacion-footer">
                                <span class="donacion-cantidad"><?= htmlspecialchars($d['cantidad']) ?></span>
                                <a href="index.php?page=beneficiario_detalle&id=<?= $d['id_donacion'] ?>" class="btn-accion">+ Ver</a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>

            </div>

            <div class="paginacion" id="paginacion">
                <p class="paginacion-info" id="paginacionInfo"></p>
                <div id="contenedorBotones"></div>
            </div>

        </main>
    </div>
</body>
</html>