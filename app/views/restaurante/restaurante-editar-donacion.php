<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlimenTICO - Editar Donación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <h1 class="titulo-pagina">EDITAR DONACIÓN</h1>
    <p class="subtitulo-pagina">MODIFICA LA INFORMACIÓN DE LA DONACIÓN:</p>

    <?php if (!$donacion): ?>
        <p>Donación no encontrada.</p>
        <a href="index.php?page=restaurante_donaciones" class="btn-volver">Volver a donaciones</a>
    <?php else: ?>

    <form id="formEditarDonacion">
        <input type="hidden" id="id_donacion" name="id_donacion" value="<?= $donacion['id_donacion'] ?>">
        
        <div class="formulario-card">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="seccion-titulo">INFORMACIÓN DEL ALIMENTO</h5>

                    <div class="campo">
                        <label for="tipo_alimento" class="label-campo">Tipo de Alimento *</label>
                        <select class="campo-input" id="tipo_alimento" name="tipo_alimento" required>
                            <option value="Comida Preparada" <?= $donacion['tipo_alimento'] == 'Comida Preparada' ? 'selected' : '' ?>>Comida Preparada</option>
                            <option value="Panaderia" <?= $donacion['tipo_alimento'] == 'Panaderia' ? 'selected' : '' ?>>Panadería</option>
                            <option value="Frutas" <?= $donacion['tipo_alimento'] == 'Frutas' ? 'selected' : '' ?>>Frutas</option>
                            <option value="Verduras" <?= $donacion['tipo_alimento'] == 'Verduras' ? 'selected' : '' ?>>Verduras</option>
                            <option value="Lacteos" <?= $donacion['tipo_alimento'] == 'Lacteos' ? 'selected' : '' ?>>Lácteos</option>
                            <option value="Otro" <?= $donacion['tipo_alimento'] == 'Otro' ? 'selected' : '' ?>>Otro</option>
                        </select>
                    </div>

                    <div class="campo">
                        <label for="nombre_descripcion" class="label-campo">Nombre o Descripción del Alimento *</label>
                        <input type="text" class="campo-input" id="nombre_descripcion" name="nombre_descripcion" value="<?= htmlspecialchars($donacion['nombre_descripcion']) ?>" required>
                    </div>

                    <div class="campo">
                        <label for="cantidad" class="label-campo">Cantidad *</label>
                        <input type="text" class="campo-input" id="cantidad" name="cantidad" value="<?= htmlspecialchars($donacion['cantidad']) ?>" required>
                    </div>

                    <div class="campo">
                        <label for="descripcion_adicional" class="label-campo">Descripción Adicional</label>
                        <textarea class="campo-input" id="descripcion_adicional" name="descripcion_adicional" rows="3"><?= htmlspecialchars($donacion['descripcion_adicional']) ?></textarea>
                    </div>

                    <div class="campo">
                        <label for="estado" class="label-campo">Estado</label>
                        <select class="campo-input" id="estado" name="estado">
                            <option value="disponible" <?= $donacion['estado'] == 'disponible' ? 'selected' : '' ?>>Disponible</option>
                            <option value="agotado" <?= $donacion['estado'] == 'agotado' ? 'selected' : '' ?>>Agotado</option>
                        </select>
                        <small class="text-muted">Si está reservado no se puede cambiar el estado</small>
                    </div>
                </div>

                <div class="col-md-6">
                    <h5 class="seccion-titulo">DISPONIBILIDAD</h5>

                    <div class="campo">
                        <label for="fecha_disponible" class="label-campo">Fecha de Disponibilidad *</label>
                        <input type="date" class="campo-input" id="fecha_disponible" name="fecha_disponible" value="<?= $donacion['fecha_disponible'] ?>" required>
                    </div>

                    <div class="campo">
                        <label for="hora_limite" class="label-campo">Hora Límite de Recogida *</label>
                        <input type="time" class="campo-input" id="hora_limite" name="hora_limite" value="<?= $donacion['hora_limite'] ?>" required>
                    </div>

                    <h5 class="seccion-titulo">INFORMACIÓN ADICIONAL</h5>
                    <p class="label-campo">Importante:</p>

                    <div class="campo">
                        <textarea class="campo-input" id="informacion_importante" name="informacion_importante" rows="3"><?= htmlspecialchars($donacion['informacion_importante']) ?></textarea>
                    </div>

                    <div class="botones">
                        <button type="reset" class="btn-accion" id="btnCancelar">Cancelar</button>
                        <button type="submit" class="btn-accion">Guardar Cambios</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <?php endif; ?>
    <div id="mensaje" style="display:none;"></div>
</main>
</body>
</html>