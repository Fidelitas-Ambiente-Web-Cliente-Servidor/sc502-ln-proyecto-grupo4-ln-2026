<?php
session_start();

require_once __DIR__ . '/app/controllers/SesionController.php';
require_once __DIR__ . '/app/controllers/RestauranteController.php';
require_once __DIR__ . '/app/controllers/BeneficiarioController.php';
require_once __DIR__ . '/app/controllers/AdminController.php';

// Protección de rutas
function verificarSesion($rolRequerido = null) {
    if (!isset($_SESSION['id_usuario'])) {
        header('Location: index.php?page=login');
        exit;
    }
    if ($rolRequerido !== null && $_SESSION['rol'] !== $rolRequerido) {
        header('Location: index.php?page=login');
        exit;
    }
}


$page = $_GET['page'] ?? 'login';

// RUTAS POST 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $option = $_POST['option'] ?? '';

    if ($option === 'login') {
        $ctrl = new SesionController();
        $ctrl->login();
        exit;
    }

    if ($option === 'registro_beneficiario') {
        $ctrl = new SesionController();
        $ctrl->registrarBeneficiario();
        exit;
    }

    if ($option === 'registro_restaurante') {
        $ctrl = new SesionController();
        $ctrl->registrarRestaurante();
        exit;
    }

    if ($option === 'logout') {
        $ctrl = new SesionController();
        $ctrl->logout();
        exit;
    }

    if ($option === 'recuperar_contrasena') {
        $ctrl = new SesionController();
        $ctrl->recuperarContrasena();
        exit;
    }

    if ($option === 'cambiar_contrasena') {
        $ctrl = new SesionController();
        $ctrl->cambiarContrasena();
        exit;
    }

}

// RUTAS GET / VISTAS
switch ($page) {

    case 'registro_beneficiario':
        $ctrl = new SesionController();
        $ctrl->showRegistroBeneficiario();
        break;

    case 'registro_restaurante':
        $ctrl = new SesionController();
        $ctrl->showRegistroRestaurante();
        break;

    case 'recuperar':
        $ctrl = new SesionController();
        $ctrl->showRecuperar();
        break;

    case 'logout':
        $ctrl = new SesionController();
        $ctrl->logout();
        break;

    case 'restaurante_panel':
        verificarSesion('restaurante');
        $ctrl = new RestauranteController();
        $ctrl->showPanel();
        break;

    case 'beneficiario_panel':
        verificarSesion('beneficiario');
        $ctrl = new BeneficiarioController();
        $ctrl->showPanel();
        break;

    case 'admin_panel':
        verificarSesion('admin');
        $ctrl = new AdminController();
        $ctrl->showPanel();
        break;
    
    case 'nueva_contrasena':
        $ctrl = new SesionController();
        $ctrl->showNuevaContrasena();
        break;

    case 'login':
    default:
        $ctrl = new SesionController();
        $ctrl->showLogin();
        break;

}