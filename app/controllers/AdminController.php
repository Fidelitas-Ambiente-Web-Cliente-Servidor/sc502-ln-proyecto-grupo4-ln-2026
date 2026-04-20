<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Restaurante.php';
require_once __DIR__ . '/../models/Beneficiario.php';
require_once __DIR__ . '/../models/Donacion.php';
require_once __DIR__ . '/../models/Reserva.php';
require_once __DIR__ . '/../models/Usuario.php';

class AdminController {

    public function showPanel() {
        $database = new Database();
        $db = $database->connect();
        $restaurante  = new Restaurante($db);
        $beneficiario = new Beneficiario($db);
        $donacion     = new Donacion($db);

        $totalRestaurantes  = $restaurante->contar();
        $totalBeneficiarios = $beneficiario->contar();
        $totalDonaciones    = $donacion->contar();

        require __DIR__ . '/../views/admin/admin-panel.php';
    }

    public function showBeneficiarios() {
        $database = new Database();
        $db = $database->connect();
        $beneficiario = new Beneficiario($db);

        $beneficiarios      = $beneficiario->obtenerTodos();
        $totalBeneficiarios = $beneficiario->contar();
        $totalActivos       = $beneficiario->contarActivos();
        $totalInactivos     = $beneficiario->contarInactivos();

        require __DIR__ . '/../views/admin/admin-beneficiarios.php';
    }

    public function showRestaurantes() {
        $database = new Database();
        $db = $database->connect();
        $restaurante = new Restaurante($db);

        $restaurantes      = $restaurante->obtenerTodos();
        $totalRestaurantes = $restaurante->contar();
        $totalActivos      = $restaurante->contarActivos();
        $totalInactivos    = $restaurante->contarInactivos();

        require __DIR__ . '/../views/admin/admin-restaurantes.php';
    }

    public function showPerfil() {
        $database = new Database();
        $db = $database->connect();
        $admin = new Usuario($db);

        $datosAdmin = $admin->obtenerPorId($_SESSION['id_usuario']);

        require __DIR__ . '/../views/admin/admin-perfil.php';
    }

    public function actualizarPerfil() {
        header('Content-Type: application/json');

        $database = new Database();
        $db = $database->connect();
        $usuarioModel = new Usuario($db);

        $id_usuario = $_SESSION['id_usuario'] ?? 0;
        if (!$id_usuario) {
            echo json_encode(['response' => '01', 'message' => 'Sesión inválida']);
            return;
        }

        $correo = $_POST['correo'] ?? '';
        if ($correo == '') {
            echo json_encode(['response' => '01', 'message' => 'El correo es obligatorio']);
            return;
        }

        $usuarioModel->actualizarCorreo($id_usuario, $correo);
        $_SESSION['correo'] = $correo;

        $contrasena = $_POST['contrasena'] ?? '';
        if ($contrasena != '') {
            $hash = password_hash($contrasena, PASSWORD_DEFAULT);
            $usuarioModel->actualizarContrasena($id_usuario, $hash);
        }

        echo json_encode(['response' => '00', 'message' => 'Perfil actualizado correctamente']);
    }

    public function eliminarPerfil() {
        $database = new Database();
        $db = $database->connect();
        $usuarioModel = new Usuario($db);

        $id_usuario = $_SESSION['id_usuario'];
        $usuarioModel->eliminarNotificaciones($id_usuario);
        $usuarioModel->eliminar($id_usuario);

        session_destroy();
        header("Location: index.php?page=login");
    }

    public function eliminarBeneficiario() {
        header('Content-Type: application/json');

        $database = new Database();
        $db = $database->connect();
        $modelBeneficiario = new Beneficiario($db);
        $modelReserva      = new Reserva($db);
        $modelUsuario      = new Usuario($db);

        $id_beneficiario = $_POST['id_beneficiario'] ?? 0;
        if (!$id_beneficiario) {
            echo json_encode(['response' => '01', 'message' => 'ID inválido']);
            return;
        }

        $beneficiario = $modelBeneficiario->getById($id_beneficiario);
        if (!$beneficiario) {
            echo json_encode(['response' => '01', 'message' => 'Beneficiario no encontrado']);
            return;
        }
        $id_usuario = $beneficiario['id_usuario'];

        $modelReserva->cancelarReservasByBeneficiario($id_beneficiario);
        $modelReserva->eliminarReservasByBeneficiario($id_beneficiario);
        $modelUsuario->eliminarNotificaciones($id_usuario);
        $modelBeneficiario->eliminar($id_beneficiario);
        $modelUsuario->eliminar($id_usuario);

        ob_clean(); // limpia cualquier output previo
        echo json_encode(['response' => '00', 'message' => 'Beneficiario eliminado correctamente']);
    }

    public function eliminarRestauranteAdmin() {
        header('Content-Type: application/json');

        $database = new Database();
        $db = $database->connect();
        $modelRestaurante = new Restaurante($db);
        $modelUsuario     = new Usuario($db);

        $id_restaurante = $_POST['id_restaurante'] ?? 0;
        if (!$id_restaurante) {
            echo json_encode(['response' => '01', 'message' => 'ID inválido']);
            return;
        }

        $perfil = $modelRestaurante->getPerfilByIdRestaurante($id_restaurante);
        if (!$perfil) {
            echo json_encode(['response' => '01', 'message' => 'Restaurante no encontrado']);
            return;
        }
        $id_usuario = $perfil['id_usuario'];

        $modelRestaurante->eliminarCuenta($id_restaurante, $id_usuario);
        $modelUsuario->eliminarNotificaciones($id_usuario);
        $modelUsuario->eliminar($id_usuario);

        echo json_encode(['response' => '00', 'message' => 'Restaurante eliminado correctamente']);
    }
}