<?php

require __DIR__ . '/../../config/database.php';
require __DIR__ . '/../models/Usuario.php';
require __DIR__ . '/../models/Restaurante.php';
require __DIR__ . '/../models/Beneficiario.php';


class SesionController {
    private $modelUsuario;
    private $modelRestaurante;
    private $modelBeneficiario;

    // IDs de roles en la BD
    const ROL_ADMIN        = 1;
    const ROL_RESTAURANTE  = 2;
    const ROL_BENEFICIARIO = 3;

    public function __construct() {
        $database = new Database();
        $db = $database->connect();
        $this->modelUsuario      = new Usuario($db);
        $this->modelRestaurante  = new Restaurante($db);
        $this->modelBeneficiario = new Beneficiario($db);
    }

    // Vistas

    public function showLogin() {
        require __DIR__ . '/../views/sesion/login.php';
    }

    public function showRecuperar() {
        require __DIR__ . '/../views/sesion/recuperar.php';
    }

    public function showRegistroBeneficiario() {
        require __DIR__ . '/../views/beneficiario/registro-beneficiario.php';
    }

    public function showRegistroRestaurante() {
        require __DIR__ . '/../views/restaurante/registro-restaurante.php';
    }

    // Acciones POST

    public function login() {
        $correo    = $_POST['correo']    ?? '';
        $contrasena = $_POST['contrasena'] ?? '';

        $usuario = $this->modelUsuario->buscarPorCorreo($correo);

        if ($usuario && password_verify($contrasena, $usuario['contrasena'])) {
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['correo']     = $usuario['correo'];
            $_SESSION['rol']        = $usuario['rol'];

            if ($usuario['rol'] === 'beneficiario') {
                $beneficiario = $this->modelBeneficiario->getByIdUsuario($usuario['id_usuario']);
                if ($beneficiario) {
                    $_SESSION['id_beneficiario'] = $beneficiario['id_beneficiario'];
                }
            }

            echo json_encode([
                'response' => '00',
                'rol'      => $usuario['rol'],
                'message'  => 'Login exitoso'
            ]);
        } else {
            echo json_encode([
                'response' => '01',
                'message'  => 'Correo o contraseña incorrectos'
            ]);
        }
    }

    public function registrarBeneficiario() {
        $correo    = $_POST['correo']    ?? '';
        $contrasena = password_hash($_POST['contrasena'] ?? '', PASSWORD_DEFAULT);

        // Verificar correo duplicado
        if ($this->modelUsuario->correoExiste($correo)) {
            echo json_encode(['response' => '01', 'message' => 'El correo ya está registrado']);
            return;
        }

        $id_usuario = $this->modelUsuario->crearUsuario($correo, $contrasena, self::ROL_BENEFICIARIO);

        if (!$id_usuario) {
            echo json_encode(['response' => '01', 'message' => 'Error al crear el usuario']);
            return;
        }

        $datos = [
            'nombre_completo'  => $_POST['nombreCompleto']  ?? '',
            'cedula_identidad' => $_POST['cedula']          ?? '',
            'telefono'         => $_POST['telefono']        ?? '',
            'provincia'        => $_POST['provincia']       ?? '',
            'canton'           => $_POST['canton']          ?? '',
            'direccion'        => $_POST['direccion']       ?? '',
            'fecha_nacimiento' => $_POST['fechaNacimiento'] ?? null,
        ];

        $ok = $this->modelBeneficiario->crear($id_usuario, $datos);

        if ($ok) {
            // Iniciar sesion automaticamente despues de registrarse
            $_SESSION['id_usuario'] = $id_usuario;
            $_SESSION['correo']     = $correo;
            $_SESSION['rol']        = 'beneficiario';
            echo json_encode(['response' => '00', 'message' => 'Registro exitoso']);
        } else {
            echo json_encode(['response' => '01', 'message' => 'Error al guardar el perfil de beneficiario']);
        }
    }

    public function registrarRestaurante() {
        $correo    = $_POST['correo']    ?? '';
        $contrasena = password_hash($_POST['contrasena'] ?? '', PASSWORD_DEFAULT);

        if ($this->modelUsuario->correoExiste($correo)) {
            echo json_encode(['response' => '01', 'message' => 'El correo ya está registrado']);
            return;
        }

        $id_usuario = $this->modelUsuario->crearUsuario($correo, $contrasena, self::ROL_RESTAURANTE);

        if (!$id_usuario) {
            echo json_encode(['response' => '01', 'message' => 'Error al crear el usuario']);
            return;
        }

        $datos = [
            'nombre_negocio'        => $_POST['nombreNegocio']       ?? '',
            'tipo_establecimiento'  => $_POST['tipoEstablecimiento'] ?? '',
            'cedula_juridica'       => $_POST['cedulaJuridica']      ?? '',
            'telefono'              => $_POST['telefono']            ?? '',
            'provincia'             => $_POST['provincia']           ?? '',
            'canton'                => $_POST['canton']              ?? '',
            'distrito'              => $_POST['distrito']            ?? '',
            'direccion_exacta'      => $_POST['direccion']           ?? '',
            'link_maps'             => $_POST['linkMaps']            ?? '',
        ];

        $id_restaurante = $this->modelRestaurante->crear($id_usuario, $datos);

        if (!$id_restaurante) {
            echo json_encode(['response' => '01', 'message' => 'Error al guardar el perfil del restaurante']);
            return;
        }

        // Guardar horarios
        $dias = ['lunes','martes','miercoles','jueves','viernes','sabado','domingo'];
        $horarios = [];
        foreach ($dias as $dia) {
            $activo = isset($_POST['switch' . ucfirst($dia)]) ? 1 : 0;
            $horarios[] = [
                'dia'           => $dia,
                'activo'        => $activo,
                'hora_apertura' => ($activo && !empty($_POST['abre' . ucfirst($dia)]))
                                    ? $_POST['abre' . ucfirst($dia)] : null,
                'hora_cierre'   => ($activo && !empty($_POST['cierra' . ucfirst($dia)]))
                                    ? $_POST['cierra' . ucfirst($dia)] : null,
            ];
        }
        $this->modelRestaurante->guardarHorarios($id_restaurante, $horarios);

        $_SESSION['id_usuario'] = $id_usuario;
        $_SESSION['correo']     = $correo;
        $_SESSION['rol']        = 'restaurante';

        echo json_encode(['response' => '00', 'message' => 'Registro exitoso']);
    }

    public function logout() {
        session_destroy();
        header('Location: index.php?page=login');
        exit;
    }

    public function recuperarContrasena() {
    require_once __DIR__ . '/../../app/services/CorreoService.php';
    
    $correo = $_POST['correo'] ?? '';
    $usuario = $this->modelUsuario->buscarPorCorreo($correo);

    if (!$usuario) {
        echo json_encode(['response' => '01', 'message' => 'No existe una cuenta con ese correo']);
        return;
    }

    $token  = bin2hex(random_bytes(32));
    $expira = date('Y-m-d H:i:s', strtotime('+1 hour'));
    $this->modelUsuario->guardarToken($correo, $token, $expira);

    $link = "http://localhost:8080/sc502-ln-proyecto-grupo4-ln-2026/index.php?page=nueva_contrasena&token=" . $token;

    $contenido = "
        <h2>Recuperar contraseña - AlimenTICO</h2>
        <p>Haga clic en el siguiente enlace para restablecer su contraseña:</p>
        <a href='$link'>$link</a>
        <p>Este enlace expira en 1 hora</p>
    ";

    try {
        $correoService = new CorreoService();
        $correoService->enviarCorreoHtml($correo, 'Recuperar contraseña - AlimenTICO', $contenido);
        echo json_encode(['response' => '00', 'message' => 'Se envio un correo de recuperacion a ' . $correo]);
    } catch (Exception $e) {
        echo json_encode(['response' => '01', 'message' => 'Error al enviar el correo: ' . $e->getMessage()]);
    }
}

public function showNuevaContrasena() {
    require __DIR__ . '/../views/sesion/nueva-contrasena.php';
}

public function cambiarContrasena() {
    $token      = $_POST['token'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';

    $usuario = $this->modelUsuario->buscarPorToken($token);

    if (!$usuario) {
        echo json_encode(['response' => '01', 'message' => 'El enlace es invalido o expiro']);
        return;
    }

    $hash = password_hash($contrasena, PASSWORD_DEFAULT);
    $ok   = $this->modelUsuario->actualizarContrasena($usuario['id_usuario'], $hash);

    if ($ok) {
        echo json_encode(['response' => '00', 'message' => 'Contraseña actualizada correctamente']);
    } else {
        echo json_encode(['response' => '01', 'message' => 'Error al actualizar la contraseña']);
    }
}
}