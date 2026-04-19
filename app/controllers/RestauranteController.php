<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Restaurante.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Donacion.php';

class RestauranteController {
    private $modelRestaurante;
    private $modelUsuario;
    private $modelDonacion;
    private $id_restaurante;
    private $id_usuario;

    public function __construct() {
        $database = new Database();
        $db = $database->connect();
        $this->modelRestaurante = new Restaurante($db);
        $this->modelUsuario = new Usuario($db);
        $this->modelDonacion = new Donacion($db);
        
        if (isset($_SESSION['id_usuario'])) {
            $this->id_usuario = $_SESSION['id_usuario'];
            $perfil = $this->modelRestaurante->getPerfilByIdUsuario($this->id_usuario);
            $this->id_restaurante = $perfil ? $perfil['id_restaurante'] : null;
            $_SESSION['id_restaurante'] = $this->id_restaurante;
        }
    }

    
     public function showPanel() {
        $estadisticas = $this->modelRestaurante->getEstadisticas($this->id_restaurante);
        $donacionesRecientes = $this->modelRestaurante->getDonacionesByRestaurante($this->id_restaurante);
        $donacionesRecientes = array_slice($donacionesRecientes, 0, 5);
        $reservasRecientes = $this->modelRestaurante->getReservasByRestaurante($this->id_restaurante);
        $reservasRecientes = array_slice($reservasRecientes, 0, 5);
        
         require __DIR__ . '/../views/restaurante/restaurante-panel.php';
     }
    
    public function showDonaciones() {
        $donaciones = $this->modelRestaurante->getDonacionesByRestaurante($this->id_restaurante);
        $estadisticas = $this->modelRestaurante->getEstadisticas($this->id_restaurante);
        require __DIR__ . '/../views/restaurante/restaurante-donaciones.php';
    }
    
    public function showNuevaDonacion() {
        require __DIR__ . '/../views/restaurante/restaurante-nueva-donacion.php';
    }
    
    public function showEditarDonacion() {
        $id_donacion = $_GET['id'] ?? 0;
        $donacion = $this->modelRestaurante->getDonacionById($id_donacion, $this->id_restaurante);
        
        if (!$donacion) {
            header('Location: index.php?page=restaurante_donaciones');
            exit;
        }
        
        require __DIR__ . '/../views/restaurante/restaurante-editar-donacion.php';
    }
    
    public function showDetalleDonacion() {
        $id_donacion = $_GET['id'] ?? 0;
        $donacion = $this->modelRestaurante->getDonacionById($id_donacion, $this->id_restaurante);
        
        if (!$donacion) {
            header('Location: index.php?page=restaurante_donaciones');
            exit;
        }
        
        $reserva = null;
        if ($donacion['estado'] === 'reservado') {
            $reservas = $this->modelRestaurante->getReservasByRestaurante($this->id_restaurante);
            foreach ($reservas as $r) {
                if ($r['id_donacion'] == $id_donacion) {
                    $reserva = $r;
                    break;
                }
            }
        }
        
        require __DIR__ . '/../views/restaurante/restaurante-detalle-donacion.php';
    }
    
    public function showPerfil() {
        $perfil = $this->modelRestaurante->getPerfilByIdUsuario($this->id_usuario);
        $horarios = $this->modelRestaurante->getHorarios($this->id_restaurante);
        
        $horariosPorDia = [];
        foreach ($horarios as $h) {
            $horariosPorDia[$h['dia']] = $h;
        }
        
        require __DIR__ . '/../views/restaurante/restaurante-perfil.php';
    }
        
    public function crearDonacion() {
        header('Content-Type: application/json');
        
        $datos = [
            'tipo_alimento' => $_POST['tipo_alimento'] ?? '',
            'nombre_descripcion' => $_POST['nombre_descripcion'] ?? '',
            'cantidad' => $_POST['cantidad'] ?? '',
            'descripcion_adicional' => $_POST['descripcion_adicional'] ?? '',
            'informacion_importante' => $_POST['informacion_importante'] ?? '',
            'fecha_disponible' => $_POST['fecha_disponible'] ?? '',
            'hora_limite' => $_POST['hora_limite'] ?? ''
        ];
        
        if (empty($datos['tipo_alimento']) || empty($datos['nombre_descripcion']) || 
            empty($datos['cantidad']) || empty($datos['fecha_disponible']) || 
            empty($datos['hora_limite'])) {
            echo json_encode(['response' => '01', 'message' => 'Todos los campos obligatorios deben estar llenos']);
            return;
        }
        
        $hoy = date('Y-m-d');
        if ($datos['fecha_disponible'] < $hoy) {
            echo json_encode(['response' => '01', 'message' => 'La fecha no puede ser anterior a hoy']);
            return;
        }
        
        $ok = $this->modelRestaurante->crearDonacion($this->id_restaurante, $datos);
        
        if ($ok) {
            echo json_encode(['response' => '00', 'message' => 'Donación creada exitosamente']);
        } else {
            echo json_encode(['response' => '01', 'message' => 'Error al crear la donación']);
        }
    }
    
    public function editarDonacion() {
        header('Content-Type: application/json');
        
        $id_donacion = $_POST['id_donacion'] ?? 0;
        
        $datos = [
            'tipo_alimento' => $_POST['tipo_alimento'] ?? '',
            'nombre_descripcion' => $_POST['nombre_descripcion'] ?? '',
            'cantidad' => $_POST['cantidad'] ?? '',
            'descripcion_adicional' => $_POST['descripcion_adicional'] ?? '',
            'informacion_importante' => $_POST['informacion_importante'] ?? '',
            'fecha_disponible' => $_POST['fecha_disponible'] ?? '',
            'hora_limite' => $_POST['hora_limite'] ?? '',
            'estado' => $_POST['estado'] ?? 'disponible'
        ];
        
        if (empty($datos['tipo_alimento']) || empty($datos['nombre_descripcion']) || 
            empty($datos['cantidad']) || empty($datos['fecha_disponible']) || 
            empty($datos['hora_limite'])) {
            echo json_encode(['response' => '01', 'message' => 'Todos los campos obligatorios deben estar llenos']);
            return;
        }
        
        $ok = $this->modelRestaurante->actualizarDonacion($id_donacion, $this->id_restaurante, $datos);
        
        if ($ok) {
            echo json_encode(['response' => '00', 'message' => 'Donación actualizada exitosamente']);
        } else {
            echo json_encode(['response' => '01', 'message' => 'Error al actualizar la donación']);
        }
    }
    
    public function eliminarDonacion() {
        header('Content-Type: application/json');
        
        $id_donacion = $_POST['id_donacion'] ?? 0;
        
        $ok = $this->modelRestaurante->eliminarDonacion($id_donacion, $this->id_restaurante);
        
        if ($ok) {
            echo json_encode(['response' => '00', 'message' => 'Donación eliminada exitosamente']);
        } else {
            echo json_encode(['response' => '01', 'message' => 'No se puede eliminar esta donación (puede estar reservada)']);
        }
    }
    
    public function confirmarEntrega() {
        header('Content-Type: application/json');
        
        $id_reserva = $_POST['id_reserva'] ?? 0;
        
        $ok = $this->modelRestaurante->confirmarEntrega($id_reserva, $this->id_restaurante);
        
        if ($ok) {
            echo json_encode(['response' => '00', 'message' => 'Entrega confirmada exitosamente']);
        } else {
            echo json_encode(['response' => '01', 'message' => 'Error al confirmar la entrega']);
        }
    }
    
    public function guardarPerfil() {
        header('Content-Type: application/json');
        
        $datos = [
            'nombre_negocio' => $_POST['nombre_negocio'] ?? '',
            'tipo_establecimiento' => $_POST['tipo_establecimiento'] ?? '',
            'cedula_juridica' => $_POST['cedula_juridica'] ?? '',
            'telefono' => $_POST['telefono'] ?? '',
            'provincia' => $_POST['provincia'] ?? '',
            'canton' => $_POST['canton'] ?? '',
            'distrito' => $_POST['distrito'] ?? '',
            'direccion_exacta' => $_POST['direccion_exacta'] ?? '',
            'link_maps' => $_POST['link_maps'] ?? ''
        ];
        
        if (empty($datos['nombre_negocio']) || empty($datos['cedula_juridica']) || 
            empty($datos['telefono']) || empty($datos['canton']) || 
            empty($datos['distrito']) || empty($datos['direccion_exacta'])) {
            echo json_encode(['response' => '01', 'message' => 'Todos los campos obligatorios deben estar llenos']);
            return;
        }
        
        $ok = $this->modelRestaurante->actualizarPerfil($this->id_restaurante, $datos);
        
        $dias = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'];
        $horarios = [];
        foreach ($dias as $dia) {
            $activo = isset($_POST['switch' . ucfirst($dia)]) ? 1 : 0;
            $horarios[] = [
                'dia' => $dia,
                'activo' => $activo,
                'hora_apertura' => ($activo && !empty($_POST['abre' . ucfirst($dia)])) ? $_POST['abre' . ucfirst($dia)] : null,
                'hora_cierre' => ($activo && !empty($_POST['cierra' . ucfirst($dia)])) ? $_POST['cierra' . ucfirst($dia)] : null,
            ];
        }
        $this->modelRestaurante->actualizarHorarios($this->id_restaurante, $horarios);
        
        $correo = $_POST['correo'] ?? '';
        if ($correo != '') {
            $this->modelUsuario->actualizarCorreo($this->id_usuario, $correo);
            $_SESSION['correo'] = $correo;
        }
        
        $contrasena = $_POST['contrasena'] ?? '';
        if ($contrasena != '') {
            $hash = password_hash($contrasena, PASSWORD_DEFAULT);
            $this->modelUsuario->actualizarContrasena($this->id_usuario, $hash);
        }
        
        echo json_encode(['response' => '00', 'message' => 'Perfil actualizado correctamente']);
    }
    
    public function eliminarCuenta() {
        header('Content-Type: application/json');
        
        $this->modelRestaurante->eliminarCuenta($this->id_restaurante, $this->id_usuario);
        $this->modelUsuario->eliminar($this->id_usuario);
        
        session_destroy();
        echo json_encode(['response' => '00', 'message' => 'Cuenta eliminada correctamente']);
    }
}