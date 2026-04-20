<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlimentTICO - Gestión de Restaurantes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/sc502-ln-proyecto-grupo4-ln-2026/public/css/restaurante.css">
    <script src="/sc502-ln-proyecto-grupo4-ln-2026/public/js/admin.js" defer></script>
</head>

<body>

    <!-- Boton del sidebar solo para celular -->
    <button class="btn-sidebar" id="btnSidebar">☰</button>

    <div class="layout">

        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-top">
                <h2 class="logo-texto">AlimenTICO <img src="/sc502-ln-proyecto-grupo4-ln-2026/public/img/donacion-de-alimentos.png" alt="logo" height="40px"></h2>
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

            <h1 class="titulo-panel">Gestión de Restaurantes</h1>

            <h5 class="seccion-titulo seccion-titulo-mt">ADMINISTRA LOS NEGOCIOS REGISTRADOS:</h5>

            <div class="estadisticas">
                <div class="estadistica-card">
                    <p>Restaurantes Totales</p>
                    <strong><?= $totalRestaurantes['total'] ?></strong>
                </div>
                <div class="estadistica-card">
                    <p>Restaurantes Activos</p>
                    <strong><?= $totalActivos['total'] ?></strong>
                </div>
                <div class="estadistica-card">
                    <p>Restaurantes Inactivos</p>
                    <strong><?= $totalInactivos['total'] ?></strong>
                </div>
            </div>

            <div class="beneficiarios-filtros">
                <div class="donaciones-buscar">
                    <label class="label-campo">Buscar:</label>
                    <div class="buscar-input-contenedor">
                        <input type="text" class="campo-input buscar-input" id="inputBuscar"
                            placeholder="Buscar Restaurante...">
                        <span class="buscar-icono"><i class="bi bi-search"></i></span>
                    </div>
                </div>
            </div>

            <h5 class="seccion-titulo">TABLA DE RESTAURANTES:</h5>

            <table class="table table-bordered tabla-panel" id="tablaBeneficiarios">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Ubicación</th>
                        <th>Total Donaciones</th>
                        <th>Estado</th>
                    </tr>
                </thead>

                <tbody id="cuerpoTabla">
                <?php foreach ($restaurantes as $r): ?>
                    <tr>
                        <td><?= $r['nombre_negocio'] ?></td>
                        <td><?= $r['tipo_establecimiento'] ?></td>
                        <td><?= $r['ubicacion'] ?></td>
                        <td><?= $r['total_donaciones'] ?></td>
                        <td class="celda-estado">
                            <?= $r['total_donaciones'] > 0 ? 'Activo' : 'Inactivo' ?>
                            <button class="btn-tabla"><i class="bi bi-trash-fill"></i></button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <div class="paginacion" id="paginacion">
                <p class="paginacion-info" id="paginacionInfo"></p>
                <div>
                    <button class="btn-pagina" id="btnAnterior"><i class="bi bi-arrow-left-square-fill"></i></button>
                    <button class="btn-pagina" id="btn1">1</button>
                    <button class="btn-pagina" id="btn2">2</button>
                    <button class="btn-pagina" id="btnSiguiente"><i class="bi bi-arrow-right-square-fill"></i></button>
                </div>
            </div>

        </main>
    </div>

</body>

</html>