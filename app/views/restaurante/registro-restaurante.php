<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlimentTICO - Registro Restaurante</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/sc502-ln-proyecto-grupo4-ln-2026/public/css/autentificacion.css">
    <script src="/sc502-ln-proyecto-grupo4-ln-2026/public/js/autentificacion.js" defer></script>
</head>
<body>
    <header>
        <div class="header-logo">
            <img src="/sc502-ln-proyecto-grupo4-ln-2026/public/img/donacion-de-alimentos.png" alt="logo" class="img-logo">
            <span class="logo-texto">Alimen<span class="logo-tico">TICO</span></span>
        </div>
        <nav>
            <a href="/sc502-ln-proyecto-grupo4-ln-2026/public/index.php">Inicio</a>
            <a href="/sc502-ln-proyecto-grupo4-ln-2026/public/index.php#nosotros">Sobre Nosotros</a>
        </nav>
        <a href="index.php?page=login" class="btn-header">Iniciar Sesión</a>
    </header>

    <main class="pagina-contenedor-ancho">
        <h1 class="titulo-pagina">FORMULARIO DE REGISTRO</h1>
        <p class="subtitulo-pagina">Registro de Restaurante, únete a la red solidaria de Costa Rica</p>

        <form id="formRegistroRestaurante">
            <div class="formulario-card">
                <div class="row">

                    <div class="col-md-6 col-izquierda">
                        <h5 class="seccion-titulo">INFORMACIÓN DEL NEGOCIO</h5>

                        <div class="campo">
                            <label for="nombreNegocio" class="label-campo">Nombre del Restaurante/Negocio</label>
                            <input type="text" class="campo-input" id="nombreNegocio" name="nombreNegocio">
                        </div>

                        <div class="campo">
                            <label for="tipoEstablecimiento" class="label-campo">Tipo de Establecimiento</label>
                            <select class="campo-input" id="tipoEstablecimiento" name="tipoEstablecimiento">
                                <option value="Restaurante" selected>Restaurante</option>
                                <option value="Panadería">Panadería</option>
                                <option value="Cafetería">Cafetería</option>
                                <option value="Sodas">Sodas</option>
                                <option value="Supermercado">Supermercado</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </div>

                        <div class="campo">
                            <label for="cedulaJuridica" class="label-campo">Cédula Jurídica</label>
                            <input type="text" class="campo-input" id="cedulaJuridica" name="cedulaJuridica">
                        </div>

                        <div class="campo">
                            <label for="telefono" class="label-campo">Teléfono del Negocio</label>
                            <input type="text" class="campo-input" id="telefono" name="telefono">
                        </div>

                        <h5 class="seccion-titulo seccion-titulo-mt">HORARIO DE OPERACIÓN</h5>

                        <?php
                        $dias = [
                            'Lunes'     => ['default' => true,  'abre' => '09:00', 'cierra' => '20:30'],
                            'Martes'    => ['default' => true,  'abre' => '09:00', 'cierra' => '20:30'],
                            'Miercoles' => ['default' => true,  'abre' => '09:00', 'cierra' => '20:30'],
                            'Jueves'    => ['default' => true,  'abre' => '09:00', 'cierra' => '20:30'],
                            'Viernes'   => ['default' => true,  'abre' => '09:00', 'cierra' => '20:30'],
                            'Sabado'    => ['default' => true,  'abre' => '10:00', 'cierra' => '20:30'],
                            'Domingo'   => ['default' => false, 'abre' => '',      'cierra' => ''],
                        ];
                        foreach ($dias as $nombre => $config):
                            $checked  = $config['default'] ? 'checked' : '';
                            $disabled = $config['default'] ? '' : 'disabled';
                            $estado   = $config['default'] ? 'Abierto' : 'Cerrado';
                            $labelNombre = $nombre === 'Miercoles' ? 'Miércoles' : ($nombre === 'Sabado' ? 'Sábado' : $nombre);
                        ?>
                        <div class="campo fila-horario">
                            <div class="fila-horario-top">
                                <span class="dia-label"><?= $labelNombre ?>:</span>
                                <div class="form-check form-switch">
                                    <input class="form-check-input switch-dia" type="checkbox"
                                           id="switch<?= $nombre ?>" <?= $checked ?>>
                                    <label class="form-check-label label-estado"
                                           for="switch<?= $nombre ?>" id="estado<?= $nombre ?>"><?= $estado ?></label>
                                </div>
                            </div>
                            <div class="fila-horario-horas">
                                <input type="time" class="campo-input input-hora"
                                       id="abre<?= $nombre ?>" <?= $disabled ?>
                                       <?= $config['abre'] ? 'value="'.$config['abre'].'"' : '' ?>>
                                <span class="label-campo">a</span>
                                <input type="time" class="campo-input input-hora"
                                       id="cierra<?= $nombre ?>" <?= $disabled ?>
                                       <?= $config['cierra'] ? 'value="'.$config['cierra'].'"' : '' ?>>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="col-md-6">
                        <h5 class="seccion-titulo">UBICACIÓN</h5>

                        <div class="campo">
                            <label for="provincia" class="label-campo">Provincia</label>
                            <select class="campo-input" id="provincia" name="provincia">
                                <option value="San José" selected>San José</option>
                                <option value="Alajuela">Alajuela</option>
                                <option value="Cartago">Cartago</option>
                                <option value="Heredia">Heredia</option>
                                <option value="Guanacaste">Guanacaste</option>
                                <option value="Puntarenas">Puntarenas</option>
                                <option value="Limón">Limón</option>
                            </select>
                        </div>

                        <div class="campo">
                            <label for="canton" class="label-campo">Cantón</label>
                            <input type="text" class="campo-input" id="canton" name="canton">
                        </div>

                        <div class="campo">
                            <label for="distrito" class="label-campo">Distrito</label>
                            <input type="text" class="campo-input" id="distrito" name="distrito">
                        </div>

                        <div class="campo">
                            <label for="direccion" class="label-campo">Dirección Exacta</label>
                            <textarea class="campo-input" id="direccion" name="direccion" rows="3"></textarea>
                        </div>

                        <div class="campo">
                            <label for="googleMaps" class="label-campo">Link de Google Maps</label>
                            <input type="text" class="campo-input" id="googleMaps" name="googleMaps">
                        </div>

                        <h5 class="seccion-titulo seccion-titulo-mt">DATOS DE ACCESO</h5>

                        <div class="campo">
                            <label for="correo" class="label-campo">Correo Electrónico</label>
                            <input type="email" class="campo-input" id="correo" name="correo">
                        </div>

                        <div class="campo">
                            <label for="contrasena" class="label-campo">Contraseña</label>
                            <input type="password" class="campo-input" id="contrasena" name="contrasena">
                        </div>

                        <div class="campo">
                            <label for="confirmarContrasena" class="label-campo">Confirmar Contraseña</label>
                            <input type="password" class="campo-input" id="confirmarContrasena" name="confirmarContrasena">
                        </div>
                    </div>
                </div>

                <div class="botones">
                    <button type="submit" class="btn-accion" id="btnRegistrar">REGISTRAR</button>
                </div>

                <div id="mensaje"></div>
                <hr>
                <div class="iniciar-sesion">
                    <label class="label-campo">¿Ya tienes cuenta?</label>
                    <a href="index.php?page=login" class="iniciar-sesion-link">Iniciar Sesión</a>
                </div>
            </div>
        </form>
    </main>
</body>
</html>