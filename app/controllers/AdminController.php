<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Restaurante.php';
require_once __DIR__ . '/../models/Beneficiario.php';
require_once __DIR__ . '/../models/Donacion.php';
require_once __DIR__ . '/../models/Usuario.php';

class AdminController {
    public function showPanel() {
    
    $database = new Database();
    $db = $database->connect();
    $restaurante = new Restaurante($db);
    $beneficiario = new Beneficiario($db);
    $donacion = new Donacion($db);

    $totalRestaurantes = $restaurante->contar();
    $totalBeneficiarios = $beneficiario->contar();
    $totalDonaciones = $donacion->contar();
        require __DIR__ . '/../views/admin/admin-panel.php';
    }

    public function showBeneficiarios() {

    $database = new Database();
    $db = $database->connect();
    $beneficiario = new Beneficiario($db);

    $beneficiarios = $beneficiario->obtenerTodos();

    $totalBeneficiarios = $beneficiario->contar();
    $totalActivos = $beneficiario->contarActivos();
    $totalInactivos = $beneficiario->contarInactivos();


    require __DIR__ . '/../views/admin/admin-beneficiarios.php';
    }

public function showRestaurantes() {

    $database = new Database();
    $db = $database->connect();
    $restaurante = new Restaurante($db);

    $restaurantes = $restaurante->obtenerTodos();

    $totalRestaurantes = $restaurante->contar();
    $totalActivos = $restaurante->contarActivos();
    $totalInactivos = $restaurante->contarInactivos();

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

    $database = new Database();
    $db = $database->connect();

    $usuarioModel = new Usuario($db);

    $id_usuario = $_SESSION['id_usuario'];
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    if (!empty($correo)) {
        $usuarioModel->actualizarCorreo($id_usuario, $correo);
    }

    if (!empty($contrasena)) {
        $hash = password_hash($contrasena, PASSWORD_DEFAULT);
        $usuarioModel->actualizarContrasena($id_usuario, $hash);
    }

    header("Location: index.php?page=admin_perfil");
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
}