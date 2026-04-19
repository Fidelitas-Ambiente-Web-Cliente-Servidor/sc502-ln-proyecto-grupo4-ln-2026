<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlimenTICO - Detalle Donación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/sc502-ln-proyecto-grupo4-ln-2026/public/css/restaurante.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="/sc502-ln-proyecto-grupo4-ln-2026/public/js/restaurante.js" defer></script>
</head>
<body>
<header class="header">
    <a href="index.php?page=restaurante_donaciones" class="btn-volver">Volver</a>
    <h2 class="logo-texto">AlimenTICO <img src="/sc502-ln-proyecto-grupo4-ln-2026/public/img/donacion-de-alimentos.png" alt="logo-alimentico" height="50px"></h2>
</header>

<main class="pagina-contenedor">
    <h1 class="titulo-pagina">Detalles de donación</h1>

    <?php if (!$donacion): ?>
        <p>Donación no encontrada.</p>
        <a href="index.php?page=restaurante_donaciones" class="btn-volver">Volver a donaciones</a>
    <?php else: ?>

    <div class="formulario-card">
        <div class="row">
            <div class="col-md-6">
                <h5 class="seccion-titulo">INFORMACIÓN DEL ALIMENTO</h5>

                <div class="campo">
                    <span class="label-campo">Tipo de Alimento</span>
                    <div class="campo-input"><?= htmlspecialchars($donacion['tipo_alimento']) ?></div>
                </div>

                <div class="campo">
                    <span class="label-campo">Nombre/Descripción del Alimento</span>
                    <div class="campo-input"><?= htmlspecialchars($donacion['nombre_descripcion']) ?></div>
                </div>

                <div class="campo">
                    <span class="label-campo">Cantidad</span>
                    <div class="campo-input"><?= htmlspecialchars($donacion['cantidad']) ?></div>
                </div>

                <div class="campo">
                    <span class="label-campo">Descripción Adicional</span>
                    <div class="campo-input campo-texto"><?= nl2br(htmlspecialchars($donacion['descripcion_adicional'])) ?></div>
                </div>

                <div class="campo">
                    <span class="label-campo">Estado</span>
                    <div class="campo-input">
                        <?php if ($donacion['estado'] == 'disponible'): ?>
                            <span class="badge bg-success">Disponible</span>
                        <?php elseif ($donacion['estado'] == 'reservado'): ?>
                            <span class="badge bg-warning">Reservado</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Agotado</span>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if ($donacion['estado'] == 'reservado' && $reserva): ?>
                    <h5 class="seccion-titulo seccion-titulo-mt">INFORMACIÓN DEL BENEFICIARIO</h5>

                    <div class="campo">
                        <span class="label-campo">Nombre</span>
                        <div class="campo-input"><?= htmlspecialchars($reserva['nombre_completo']) ?></div>
                    </div>

                    <div class="campo">
                        <span class="label-campo">Cédula</span>
                        <div class="campo-input"><?= htmlspecialchars($reserva['cedula_identidad']) ?></div>
                    </div>

                    <div class="campo">
                        <span class="label-campo">Teléfono</span>
                        <div class="campo-input"><?= htmlspecialchars($reserva['telefono']) ?></div>
                    </div>

                    <div class="campo">
                        <span class="label-campo">Código de reserva</span>
                        <div class="campo-input"><strong><?= htmlspecialchars($reserva['codigo_reserva']) ?></strong></div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-md-6">
                <h5 class="seccion-titulo">DISPONIBILIDAD</h5>

                <div class="campo">
                    <span class="label-campo">Fecha de Disponibilidad</span>
                    <div class="campo-input"><?= date('d/m/Y', strtotime($donacion['fecha_disponible'])) ?></div>
                </div>

                <div class="campo">
                    <span class="label-campo">Hora Límite de Recogida</span>
                    <div class="campo-input"><?= date('g:i A', strtotime($donacion['hora_limite'])) ?></div>
                </div>

                <h5 class="seccion-titulo">INFORMACIÓN ADICIONAL</h5>
                <span class="label-campo">Importante:</span>

                <div class="campo">
                    <div class="campo-input campo-texto"><?= nl2br(htmlspecialchars($donacion['informacion_importante'])) ?></div>
                </div>

                <?php if ($donacion['estado'] == 'reservado' && $reserva && $reserva['reserva_estado'] == 'activa'): ?>
                    <h5 class="seccion-titulo">ACCIONES</h5>

                    <div class="campo">
                        <span class="label-campo">¿El beneficiario ya recogió la donación?</span>
                        <div class="boton-accion">
                            <button class="btn-accion" id="btnConfirmarEntrega" data-id="<?= $reserva['id_reserva'] ?>" data-nombre="<?= htmlspecialchars($donacion['nombre_descripcion']) ?>">
                                Marcar como Entregado
                            </button>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <div id="mensaje" style="display:none;"></div>
</main>
</body>
</html>