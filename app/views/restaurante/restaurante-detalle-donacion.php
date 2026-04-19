<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlimentTICO - Detalle Donación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="/sc502-ln-proyecto-grupo4-ln-2026/public/css/restaurante.css">
    
    <script src="public/js/restaurante.js"></script>
</head>

<body>

    <header class="header">
        <a href="index.php?page=donaciones" class="btn-volver">Volver</a>
        <h2 class="logo-texto">AlimenTICO <img src="../img/donacion-de-alimentos.png" alt="logo-alimentico" height="50px"></h2>
    </header>

    <main class="pagina-contenedor">

        <h1 class="titulo-pagina">Detalles de donación</h1>
        <p class="subtitulo-pagina">COMPLETA LA INFORMACIÓN DE LOS ALIMENTOS DISPONIBLES:</p>

        <div class="formulario-card">
            <div class="row">

                <div class="col-md-6">
                    <h5 class="seccion-titulo">INFORMACIÓN DEL ALIMENTO</h5>
                    <?php if (!empty($donacion)) {?>
                    <div class="campo">
                        <span class="label-campo">Tipo de Alimento</span>
                        <div class="campo-input"><?= $donacion['tipoAlimento'] ?></div>
                    </div>

                    <div class="campo">
                        <span class="label-campo">Nombre/Descripción del Alimento</span>
                        <div class="campo-input"><?= $donacion['nombre'] ?></div>
                    </div>

                    <div class="campo">
                        <span class="label-campo">Cantidad</span>
                        <div class="campo-input"><?= $donacion['cantidad'] ?></div>
                    </div>

                    <div class="campo">
                        <span class="label-campo">Descripción Adicional</span>
                        <div class="campo-input campo-texto"><?= $donacion['descripcionAdicional'] ?></div>
                    </div>

                    <div class="campo">
                        <span class="label-campo">Estado</span>
                        <div class="campo-input"><?= $donacion['estado'] ?></div>
                    </div>

                    <h5 class="seccion-titulo seccion-titulo-mt">INFORMACIÓN DEL RESTAURANTE</h5>

                    <div class="campo">
                        <span class="label-campo">Nombre</span>
                        <div class="campo-input"><?= $donacion['restaurante'] ?></div>
                    </div>

                    <div class="campo">
                        <span class="label-campo">Provincia</span>
                        <div class="campo-input"><?= $donacion['provincia'] ?></div>
                    </div>

                    <div class="campo">
                        <span class="label-campo">Cantón</span>
                        <div class="campo-input"><?= $donacion['canton'] ?></div>
                    </div>
                    <div class="campo">
                        <span class="label-campo">Distrito</span>
                        <div class="campo-input"><?= $donacion['distrito'] ?></div>
                    </div>
                    <div class="campo">
                        <span class="label-campo">Direccion</span>
                        <div class="campo-input campo-texto"><?= $donacion['direccion'] ?></div>
                    </div>

                </div>

                <div class="col-md-6">
                    <h5 class="seccion-titulo">DISPONIBILIDAD</h5>

                    <div class="campo">
                        <span class="label-campo">Fecha de Disponibilidad</span>
                        <div class="campo-input"><?= $donacion['fechaDisponible'] ?></div>
                    </div>

                    <div class="campo">
                        <span class="label-campo">Hora Límite de Recogida</span>
                        <div class="campo-input"><?= $donacion['horaLimite'] ?></div>
                    </div>

                    <h5 class="seccion-titulo">INFORMACIÓN ADICIONAL</h5>
                    <span class="label-campo">Importante:</span>

                    <div class="campo">
                        <div class="campo-input campo-texto"><?= $donacion['informacionImportante'] ?></div>
                    </div>

                    <h5 class="seccion-titulo">ACCIONES</h5>

                    <div class="campo">
                        <span class="label-campo">El beneficiario ya recogió la donación?</span>
                        <div class="boton-accion">
                            <form action="/sc502-ln-proyecto-grupo4-ln-2026/index.php" method="POST">
                                <input type="hidden" name="option" value="cambiarEstado">
                                <input type="hidden" name="estado" value="reservado">
                                <input type="hidden" name="idDonacion" value="<?= $donacion['idDonacion'] ?>">
                                <button type="submit" class="btn-accion">Entregado</button>
                            </form>
                            
                            
                        </div>
                    </div>

                    <div class="campo">
                        <span class="label-campo">Si el beneficiario no llegó: </span>
                        <div class="boton-accion">
                            <form action="/sc502-ln-proyecto-grupo4-ln-2026/index.php" method="POST">
                                <input type="hidden" name="option" value="cambiarEstado">
                                <input type="hidden" name="estado" value="agotado">
                                <input type="hidden" name="idDonacion" value="<?= $donacion['idDonacion'] ?>">
                                <button type="submit" class="btn-accion">Cancelar</button>
                            </form>
                        </div>
                    </div>
                    <?php } ?>

                </div>
            </div>
        </div>

    </main>

</body>

</html>