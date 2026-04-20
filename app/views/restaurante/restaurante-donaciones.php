<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlimenTICO - Mis Donaciones</title>
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
                <h2 class="logo-texto">AlimenTICO <img
                        src="/sc502-ln-proyecto-grupo4-ln-2026/public/img/donacion-de-alimentos.png" alt="logo"
                        height="40px"></h2>
                <button class="btn-cerrar-sidebar" id="btnCerrarSidebar">✕</button>
            </div>
            <nav class="sidebar-nav">
                <a href="index.php?page=restaurante_panel" class="sidebar-link">Panel Principal</a>
                <a href="index.php?page=restaurante_donaciones" class="sidebar-link activo">Donaciones</a>
                <a href="index.php?page=restaurante_perfil" class="sidebar-link">Perfil</a>
                <a href="index.php?page=logout" class="sidebar-link">Cerrar Sesión</a>
            </nav>
        </aside>

        <main class="panel-contenido">
            <h1 class="titulo-panel">Mis Donaciones</h1>
            <a href="index.php?page=restaurante_nueva_donacion" class="btn-volver">+ Donar</a>

            <h5 class="seccion-titulo seccion-titulo-mt">ADMINISTRA TUS PUBLICACIONES:</h5>

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
                    <p>Completadas</p>
                    <strong><?= $estadisticas['completados'] ?? 0 ?></strong>
                </div>
                <div class="estadistica-card">
                    <p>Total Donaciones</p>
                    <strong><?= $estadisticas['total'] ?? 0 ?></strong>
                </div>
            </div>

            <div class="donaciones-filtros">
                <div class="donaciones-buscar">
                    <label class="label-campo">Buscar:</label>
                    <div class="buscar-input-contenedor">
                        <input type="text" class="campo-input buscar-input" id="inputBuscar"
                            placeholder="Buscar donación...">
                        <span class="buscar-icono"><i class="bi bi-search"></i></span>
                    </div>
                </div>
                <div class="donaciones-filtrar">
                    <label class="label-campo">Filtrar:</label>
                    <div>
                        <select class="campo-input filtro-select" id="filtroEstado">
                            <option value="">Todos los estados</option>
                            <option value="disponible">Disponible</option>
                            <option value="reservado">Reservado</option>
                            <option value="agotado">Agotado</option>
                            <option value="completado">Completado</option>
                        </select>
                    </div>
                </div>
            </div>

            <h5 class="seccion-titulo">TABLA DE DONACIONES:</h5>

            <table class="table table-bordered tabla-panel" id="tablaDonaciones">
                <thead>
                    <tr>
                        <th>Alimento</th>
                        <th>Cantidad</th>
                        <th>Fecha</th>
                        <th>Hora Límite</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="cuerpoTabla">
                    <?php if (empty($donaciones)): ?>
                        <tr>
                            <td colspan="6" class="text-center">No hay donaciones registradas</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($donaciones as $d): ?>
                            <tr data-estado="<?= $d['estado'] ?>">
                                <td><?= htmlspecialchars($d['nombre_descripcion']) ?></td>
                                <td><?= htmlspecialchars($d['cantidad']) ?></td>
                                <td><?= date('d/m/Y', strtotime($d['fecha_disponible'])) ?></td>
                                <td><?= date('g:i A', strtotime($d['hora_limite'])) ?></td>
                                <td class="celda-estado">
                                    <?php if ($d['estado'] == 'disponible'): ?>
                                        <span class="badge bg-success">Disponible</span>
                                    <?php elseif ($d['estado'] == 'reservado'): ?>
                                        <span class="badge bg-warning">Reservado</span>
                                    <?php elseif ($d['estado'] == 'agotado'): ?>
                                        <span class="badge bg-secondary">Agotado</span>
                                    <?php else: ?>
                                        <span class="badge bg-primary">Completado</span>
                                    <?php endif; ?>
                                </td>
                                <td class="celda-estado">
                                    <a href="index.php?page=restaurante_detalle_donacion&id=<?= $d['id_donacion'] ?>"
                                        class="btn-tabla" title="Ver detalle">
                                        <i class="bi bi-info-square-fill"></i>
                                    </a>
                                    <?php if ($d['estado'] == 'disponible' || $d['estado'] == 'agotado'): ?>
                                        <a href="index.php?page=restaurante_editar_donacion&id=<?= $d['id_donacion'] ?>"
                                            class="btn-tabla" title="Editar">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <button class="btn-tabla btn-eliminar-donacion" data-id="<?= $d['id_donacion'] ?>"
                                            data-nombre="<?= htmlspecialchars($d['nombre_descripcion']) ?>" title="Eliminar">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    <?php elseif ($d['estado'] == 'reservado'): ?>
                                        <button class="btn-tabla btn-completar-donacion" data-id="<?= $d['id_donacion'] ?>"
                                            data-nombre="<?= htmlspecialchars($d['nombre_descripcion']) ?>"
                                            title="Marcar como completada">
                                            <i class="bi bi-check-circle-fill"></i>
                                        </button>
                                        <button class="btn-tabla" disabled title="No se puede editar (está reservado)">
                                            <i class="bi bi-pencil-square" style="opacity:0.5"></i>
                                        </button>
                                        <button class="btn-tabla" disabled title="No se puede eliminar (está reservado)">
                                            <i class="bi bi-trash-fill" style="opacity:0.5"></i>
                                        </button>
                                    <?php else: ?>
                                        <button class="btn-tabla" disabled><i class="bi bi-pencil-square"
                                                style="opacity:0.5"></i></button>
                                        <button class="btn-tabla" disabled><i class="bi bi-trash-fill"
                                                style="opacity:0.5"></i></button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>

            <div id="mensaje" style="display:none;"></div>
        </main>
    </div>

    <script>
        $(document).ready(function () {
            $('#filtroEstado').on('change', function () {
                var estado = $(this).val();
                $('#cuerpoTabla tr').each(function () {
                    if (estado === '' || $(this).data('estado') === estado) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });

            $('#inputBuscar').on('keyup', function () {
                var texto = $(this).val().toLowerCase();
                $('#cuerpoTabla tr').each(function () {
                    var nombre = $(this).find('td:first').text().toLowerCase();
                    if (nombre.includes(texto)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });

            // Eliminar donación
            $('.btn-eliminar-donacion').on('click', function () {
                var id = $(this).data('id');
                var nombre = $(this).data('nombre');

                if (confirm('¿Estás seguro de eliminar la donación "' + nombre + '"? Esta acción no se puede deshacer.')) {
                    $.post('index.php', {
                        option: 'eliminar_donacion',
                        id_donacion: id
                    }, function (data) {
                        if (data.response === '00') {
                            $('#mensaje').html(data.message).css('background-color', 'rgba(65, 201, 7, 0.8)').show();
                            setTimeout(function () {
                                location.reload();
                            }, 1500);
                        } else {
                            $('#mensaje').html(data.message).css('background-color', 'rgba(149, 24, 24, 0.758)').show();
                        }
                    }, 'json');
                }
            });
        });
    </script>

</body>

</html>