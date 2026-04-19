<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Restaurante.php';
require_once __DIR__ . '/../models/Donacion.php';

class DonacionesController {
    private $modelUsuario;
    private $modelRestaurante;
    private $modelDonacion;

    public function showPanel() {
        require __DIR__ . '/../views/restaurante/restaurante-panel.php';
    }

    public function __construct() {
        $database = new Database();
        $db = $database->connect();
        $this->modelUsuario      = new Usuario($db);
        $this->modelRestaurante  = new Restaurante($db);
        $this->modelDonacion = new Donacion($db);
    }

    public function showNuevaDonacion() {
        require __DIR__ . '/../views/restaurante/restaurante-nueva-donacion.php';
    }

    public function nuevaDonacion()
    {
        $restauranteId= $_SESSION['id_usuario'] ;
        $tipoAlimento = $_POST['tipoAlimento'];
        $nombreDescripcion = $_POST['nombreDescripcion'];
        $cantidad = $_POST['cantidad'];
        $descripcionAdicional = $_POST['descripcionAdicional'];
        $informacionImportante = $_POST['informacionImportante'];
        $fechaDisponible = $_POST['fechaDisponible'];
        $horaLimite = $_POST['horaLimite'];
        $estado = $_POST['estado'];

        $idDonacion=$this->modelDonacion->nuevaDonacion($restauranteId,$tipoAlimento,$nombreDescripcion,$cantidad, $descripcionAdicional,
        $informacionImportante,$fechaDisponible,$horaLimite,$estado);
        if (!$idDonacion) {
            echo json_encode(['response' => '01', 'message' => 'Error al crear la donacion']);
            return;
        }

        echo json_encode(['response' => '00', 'message' => 'Ingreso de donacion exitoso']);
        
    }
}