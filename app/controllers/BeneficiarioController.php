<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Donacion.php';
require_once __DIR__ . '/../models/Beneficiario.php';
require_once __DIR__ . '/../models/Reserva.php';

class BeneficiarioController {
    private $modelDonacion;
    private $modelBeneficiario;
    private $modelReserva;

    public function __construct() {
        $database = new Database();
        $db = $database->connect();
        $this->modelDonacion     = new Donacion($db);
        $this->modelBeneficiario = new Beneficiario($db);
        $this->modelReserva      = new Reserva($db);
    }

    public function showPanel() {
        $donaciones = $this->modelDonacion->getDonacionesDisponibles();
        require __DIR__ . '/../views/beneficiario/beneficiario-panel.php';
    }

    public function showDetalle() {
        $id_donacion = $_GET['id'] ?? 0;
        $donacion = $this->modelDonacion->getDonacionById($id_donacion);
        require __DIR__ . '/../views/beneficiario/beneficiario-detalle.php';
    }

    public function showReservas() {
        require __DIR__ . '/../views/beneficiario/beneficiario-reservas.php';
    }

    public function showPerfil() {
        require __DIR__ . '/../views/beneficiario/beneficiario-perfil.php';
    }

    public function reservar() {
        $id_donacion     = $_POST['id_donacion'] ?? 0;
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
                'message'  => '¡Reserva exitosa! Su código es ' . $codigo . '. Presentalo al retirar la donación.',
                'codigo'   => $codigo
            ]);
        } else {
            echo json_encode(['response' => '01', 'message' => 'Error al crear la reserva']);
        }
    }
}