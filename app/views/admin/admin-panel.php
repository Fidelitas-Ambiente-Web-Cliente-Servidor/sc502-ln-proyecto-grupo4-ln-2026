<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlimentTICO - Panel Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="/sc502-ln-proyecto-grupo4-ln-2026/public/css/admin.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
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
                <button class="btn-cerrar-sidebar" id="btnCerrarSidebar">✕</button>
            </div>
            <nav class="sidebar-nav">
                <a href="index.php?page=admin-panel" class="sidebar-link activo">Panel Principal</a>
                <a href="index.php?page=admin_beneficiarios" class="sidebar-link">Beneficiarios</a>
                <a href="index.php?page=admin_restaurantes" class="sidebar-link">Restaurantes</a>
                <a href="index.php?page=admin_perfil" class="sidebar-link">Perfil</a>
                <a href="index.php?page=logout" class="sidebar-link">Cerrar Sesión</a>
            </nav>
        </aside>

         <!-- Contenido principal-->
        <main class="panel-contenido">

            <h1 class="titulo-panel">Resumen General de la Plataforma</h1>

            <h5 class="seccion-titulo seccion-titulo-mt">ESTADÍSTICAS PRINCIPALES:</h5>

            <div class="estadisticas">
                <div class="estadistica-card">
                    <p>Restaurantes Registrados</p>
                    <strong><?= $totalRestaurantes['total'] ?></strong>
                </div>
                <div class="estadistica-card">
                    <p>Beneficiarios Registrados</p>
                    <strong><?= $totalBeneficiarios['total'] ?></strong>
                </div>
                <div class="estadistica-card">
                    <p>Donaciones Totales</p>
                    <strong><?= $totalDonaciones['total'] ?></strong>
                </div>
            </div>

            <div class="img-panel">
            <img src="/sc502-ln-proyecto-grupo4-ln-2026/public/img/donacion-de-alimentos.png" alt="logo" height="400px">
            </div>
        </main>

</body>

</html>