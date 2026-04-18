<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Donacion.php';
require_once __DIR__ . '/../models/Beneficiario.php';
require_once __DIR__ . '/../models/Reserva.php';
require_once __DIR__ . '/../models/Usuario.php';

class BeneficiarioController
{
    private $modelDonacion;
    private $modelBeneficiario;
    private $modelReserva;
    private $modelUsuario;

    public function __construct()
    {
        $database = new Database();
        $db = $database->connect();
        $this->modelDonacion = new Donacion($db);
        $this->modelBeneficiario = new Beneficiario($db);
        $this->modelReserva = new Reserva($db);
        $this->modelUsuario = new Usuario($db);
    }

    public function showPanel()
    {
        $donaciones = $this->modelDonacion->getDonacionesDisponibles();
        require __DIR__ . '/../views/beneficiario/beneficiario-panel.php';
    }

    public function showDetalle()
    {
        $id_donacion = $_GET['id'] ?? 0;
        $donacion = $this->modelDonacion->getDonacionById($id_donacion);
        require __DIR__ . '/../views/beneficiario/beneficiario-detalle.php';
    }

    public function showReservas()
    {
        $id_beneficiario = $_SESSION['id_beneficiario'] ?? 0;
        $reservas = $this->modelReserva->getReservasByBeneficiario($id_beneficiario);

        $activas = array_filter($reservas, fn($r) => $r['estado'] === 'activa');
        $confirmadas = array_filter($reservas, fn($r) => $r['estado'] === 'confirmada');
        $canceladas = array_filter($reservas, fn($r) => $r['estado'] === 'cancelada');

        require __DIR__ . '/../views/beneficiario/beneficiario-reservas.php';
    }

    public function confirmarReserva()
    {
        header('Content-Type: application/json');
        $id_reserva = $_POST['id_reserva'] ?? 0;
        $id_beneficiario = $_SESSION['id_beneficiario'] ?? 0;

        if (!$id_beneficiario) {
            echo json_encode(['response' => '01', 'message' => 'Sesión inválida']);
            return;
        }

        $ok = $this->modelReserva->confirmarReserva($id_reserva, $id_beneficiario);
        if ($ok) {
            echo json_encode(['response' => '00', 'message' => 'Retiro confirmado correctamente']);
        } else {
            echo json_encode(['response' => '01', 'message' => 'No se pudo confirmar la reserva']);
        }
    }

    public function cancelarReserva()
    {
        header('Content-Type: application/json');
        $id_reserva = $_POST['id_reserva'] ?? 0;
        $id_beneficiario = $_SESSION['id_beneficiario'] ?? 0;

        if (!$id_beneficiario) {
            echo json_encode(['response' => '01', 'message' => 'Sesión inválida']);
            return;
        }

        $ok = $this->modelReserva->cancelarReserva($id_reserva, $id_beneficiario);
        if ($ok) {
            echo json_encode(['response' => '00', 'message' => 'Reserva cancelada']);
        } else {
            echo json_encode(['response' => '01', 'message' => 'No se pudo cancelar la reserva']);
        }
    }

    public function showPerfil()
    {
        $id_beneficiario = $_SESSION['id_beneficiario'] ?? 0;
        $beneficiario = $this->modelBeneficiario->getByIdUsuario($_SESSION['id_usuario']);
        require __DIR__ . '/../views/beneficiario/beneficiario-perfil.php';
    }

    public function guardarPerfil()
    {
        $id_beneficiario = $_SESSION['id_beneficiario'] ?? 0;
        $id_usuario = $_SESSION['id_usuario'] ?? 0;

        if (!$id_beneficiario) {
            echo json_encode(['response' => '01', 'message' => 'Sesión inválida']);
            return;
        }

        $datos = [
            'nombre_completo' => $_POST['nombreCompleto'] ?? '',
            'cedula_identidad' => $_POST['identificacion'] ?? '',
            'telefono' => $_POST['telefono'] ?? '',
            'provincia' => $_POST['provincia'] ?? '',
            'canton' => $_POST['canton'] ?? '',
            'direccion' => $_POST['direccion'] ?? '',
            'fecha_nacimiento' => $_POST['fechaNacimiento'] ?? null,
        ];

        // Actualizar datos personales
        $this->modelBeneficiario->actualizar($id_beneficiario, $datos);

        // Actualizar correo
        $correo = $_POST['correo'] ?? '';
        if ($correo != '') {
            $this->modelUsuario->actualizarCorreo($id_usuario, $correo);
            $_SESSION['correo'] = $correo;
        }

        // Actualizar contraseña solo si se ingresó una
        $contrasena = $_POST['contrasena'] ?? '';
        if ($contrasena != '') {
            $hash = password_hash($contrasena, PASSWORD_DEFAULT);
            $this->modelUsuario->actualizarContrasena($id_usuario, $hash);
        }

        echo json_encode(['response' => '00', 'message' => 'Perfil actualizado correctamente']);
    }

    public function eliminarCuenta()
    {
        $id_beneficiario = $_SESSION['id_beneficiario'] ?? 0;
        $id_usuario = $_SESSION['id_usuario'] ?? 0;

        if (!$id_beneficiario) {
            echo json_encode(['response' => '01', 'message' => 'Sesión inválida']);
            return;
        }
        // Hay que devolver donaciones activas a disponible
        $this->modelReserva->cancelarReservasByBeneficiario($id_beneficiario);
        // Luego eliminar todas las reservas del beneficiario
        $this->modelReserva->eliminarReservasByBeneficiario($id_beneficiario);
        // Luego eliminar notificaciones
        $this->modelUsuario->eliminarNotificaciones($id_usuario);
        // Luego eliminar el perfil de beneficiario
        $this->modelBeneficiario->eliminar($id_beneficiario);
        // Luego eliminar el usuario
        $this->modelUsuario->eliminar($id_usuario);

        // Y por ultimo cerrar sesion
        session_destroy();
        echo json_encode(['response' => '00', 'message' => 'Cuenta eliminada correctamente']);
    }

    public function reservar()
    {
        $id_donacion = $_POST['id_donacion'] ?? 0;
        $id_beneficiario = $_SESSION['id_beneficiario'] ?? 0;

        if (!$id_beneficiario) {
            echo json_encode(['response' => '01', 'message' => 'Sesion invalida, tiene que volver a iniciar sesion']);
            return;
        }

        // Verificar que la donacion existe y está disponible
        $donacion = $this->modelDonacion->getDonacionById($id_donacion);

        if (!$donacion) {
            echo json_encode(['response' => '01', 'message' => 'La donación no existe']);
            return;
        }

        if ($donacion['estado'] !== 'disponible') {
            echo json_encode(['response' => '01', 'message' => 'Esta donación ya no está disponible']);
            return;
        }

        // Verificar que no haya reservado ya esta donacion
        if ($this->modelReserva->beneficiarioYaReservo($id_donacion, $id_beneficiario)) {
            echo json_encode(['response' => '01', 'message' => 'Ya tiene una reserva activa para esta donación']);
            return;
        }

        $codigo = $this->modelReserva->crear($id_donacion, $id_beneficiario);

        if ($codigo) {
            echo json_encode([
                'response' => '00',
                'message' => '¡Reserva exitosa! Su código es ' . $codigo . '. Presentalo al retirar la donación.',
                'codigo' => $codigo
            ]);
        } else {
            echo json_encode(['response' => '01', 'message' => 'Error al crear la reserva']);
        }
    }
}