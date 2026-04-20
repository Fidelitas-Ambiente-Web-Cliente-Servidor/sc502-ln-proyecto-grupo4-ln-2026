<?php
class Restaurante
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function crear($id_usuario, $datos)
    {
        $query = "INSERT INTO restauranteProyecto 
                    (id_usuario, nombre_negocio, tipo_establecimiento, cedula_juridica,
                     telefono, provincia, canton, distrito, direccion_exacta, link_maps)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param(
            "isssssssss",
            $id_usuario,
            $datos['nombre_negocio'],
            $datos['tipo_establecimiento'],
            $datos['cedula_juridica'],
            $datos['telefono'],
            $datos['provincia'],
            $datos['canton'],
            $datos['distrito'],
            $datos['direccion_exacta'],
            $datos['link_maps']
        );
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return $stmt->insert_id;
        }
        return false;
    }

    public function guardarHorarios($id_restaurante, $horarios)
    {
        $query = "INSERT INTO horarioProyecto (id_restaurante, dia, activo, hora_apertura, hora_cierre)
                  VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        foreach ($horarios as $h) {
            $stmt->bind_param(
                "isiss",
                $id_restaurante,
                $h['dia'],
                $h['activo'],
                $h['hora_apertura'],
                $h['hora_cierre']
            );
            $stmt->execute();
        }
        return true;
    }

    public function getPerfilByIdUsuario($id_usuario)
    {
        $query = "SELECT r.*, u.correo 
                  FROM restauranteProyecto r
                  INNER JOIN usuarioProyecto u ON r.id_usuario = u.id_usuario
                  WHERE r.id_usuario = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getPerfilByIdRestaurante($id_restaurante)
    {
        $query = "SELECT r.*, u.correo 
                  FROM restauranteProyecto r
                  INNER JOIN usuarioProyecto u ON r.id_usuario = u.id_usuario
                  WHERE r.id_restaurante = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_restaurante);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function actualizarPerfil($id_restaurante, $datos)
    {
        $query = "UPDATE restauranteProyecto 
                  SET nombre_negocio = ?, tipo_establecimiento = ?, cedula_juridica = ?,
                      telefono = ?, provincia = ?, canton = ?, distrito = ?,
                      direccion_exacta = ?, link_maps = ?
                  WHERE id_restaurante = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param(
            "sssssssssi",
            $datos['nombre_negocio'],
            $datos['tipo_establecimiento'],
            $datos['cedula_juridica'],
            $datos['telefono'],
            $datos['provincia'],
            $datos['canton'],
            $datos['distrito'],
            $datos['direccion_exacta'],
            $datos['link_maps'],
            $id_restaurante
        );
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    public function getHorarios($id_restaurante)
    {
        $query = "SELECT * FROM horarioProyecto WHERE id_restaurante = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_restaurante);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function actualizarHorarios($id_restaurante, $horarios)
    {
        $queryDelete = "DELETE FROM horarioProyecto WHERE id_restaurante = ?";
        $stmtDelete = $this->conn->prepare($queryDelete);
        $stmtDelete->bind_param("i", $id_restaurante);
        $stmtDelete->execute();

        return $this->guardarHorarios($id_restaurante, $horarios);
    }

    public function getDonacionesByRestaurante($id_restaurante)
    {
        $query = "SELECT * FROM donacionProyecto 
                  WHERE id_restaurante = ? 
                  ORDER BY fecha_disponible DESC, fecha_creacion DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_restaurante);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getDonacionesActivasByRestaurante($id_restaurante)
    {
        $query = "SELECT * FROM donacionProyecto 
                  WHERE id_restaurante = ? AND estado IN ('disponible', 'reservado')
                  ORDER BY fecha_disponible ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_restaurante);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getDonacionById($id_donacion, $id_restaurante)
    {
        $query = "SELECT * FROM donacionProyecto 
                  WHERE id_donacion = ? AND id_restaurante = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $id_donacion, $id_restaurante);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function crearDonacion($id_restaurante, $datos)
    {
        $query = "INSERT INTO donacionProyecto 
                  (id_restaurante, tipo_alimento, nombre_descripcion, cantidad, 
                   descripcion_adicional, informacion_importante, fecha_disponible, hora_limite, estado)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'disponible')";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param(
            "isssssss",
            $id_restaurante,
            $datos['tipo_alimento'],
            $datos['nombre_descripcion'],
            $datos['cantidad'],
            $datos['descripcion_adicional'],
            $datos['informacion_importante'],
            $datos['fecha_disponible'],
            $datos['hora_limite']
        );
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    public function actualizarDonacion($id_donacion, $id_restaurante, $datos)
    {
        $query = "UPDATE donacionProyecto 
                  SET tipo_alimento = ?, nombre_descripcion = ?, cantidad = ?,
                      descripcion_adicional = ?, informacion_importante = ?,
                      fecha_disponible = ?, hora_limite = ?, estado = ?
                  WHERE id_donacion = ? AND id_restaurante = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param(
            "ssssssssii",
            $datos['tipo_alimento'],
            $datos['nombre_descripcion'],
            $datos['cantidad'],
            $datos['descripcion_adicional'],
            $datos['informacion_importante'],
            $datos['fecha_disponible'],
            $datos['hora_limite'],
            $datos['estado'],
            $id_donacion,
            $id_restaurante
        );
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    public function eliminarDonacion($id_donacion, $id_restaurante)
    {
        $query = "DELETE FROM donacionProyecto 
                  WHERE id_donacion = ? AND id_restaurante = ? 
                  AND estado IN ('disponible', 'agotado')";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $id_donacion, $id_restaurante);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    public function cambiarEstadoDonacion($id_donacion, $id_restaurante, $estado)
    {
        $query = "UPDATE donacionProyecto 
                  SET estado = ? 
                  WHERE id_donacion = ? AND id_restaurante = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sii", $estado, $id_donacion, $id_restaurante);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    public function getEstadisticas($id_restaurante)
    {
        $query = "SELECT 
                    SUM(CASE WHEN estado = 'disponible' THEN 1 ELSE 0 END) as disponibles,
                    SUM(CASE WHEN estado = 'reservado' THEN 1 ELSE 0 END) as reservados,
                    SUM(CASE WHEN estado = 'agotado' THEN 1 ELSE 0 END) as agotados,
                    COUNT(*) as total
                  FROM donacionProyecto 
                  WHERE id_restaurante = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_restaurante);
        $stmt->execute();
        $result = $stmt->get_result();
        $stats = $result->fetch_assoc();

        return [
            'disponibles' => $stats['disponibles'] ?? 0,
            'reservados' => $stats['reservados'] ?? 0,
            'agotados' => $stats['agotados'] ?? 0,
            'total' => $stats['total'] ?? 0
        ];
    }

    public function getReservasByRestaurante($id_restaurante)
    {
        $query = "SELECT r.id_reserva, r.codigo_reserva, r.estado as reserva_estado, r.fecha_reserva,
                         d.id_donacion, d.nombre_descripcion, d.fecha_disponible, d.hora_limite, d.estado as donacion_estado,
                         b.id_beneficiario, b.nombre_completo, b.cedula_identidad, b.telefono
                  FROM reservaProyecto r
                  INNER JOIN donacionProyecto d ON r.id_donacion = d.id_donacion
                  INNER JOIN beneficiarioProyecto b ON r.id_beneficiario = b.id_beneficiario
                  WHERE d.id_restaurante = ?
                  ORDER BY r.fecha_reserva DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_restaurante);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }


    public function getReservasActivasByRestaurante($id_restaurante)
    {
        $query = "SELECT r.id_reserva, r.codigo_reserva, r.estado as reserva_estado, r.fecha_reserva,
                         d.id_donacion, d.nombre_descripcion, d.fecha_disponible, d.hora_limite,
                         b.nombre_completo, b.telefono
                  FROM reservaProyecto r
                  INNER JOIN donacionProyecto d ON r.id_donacion = d.id_donacion
                  INNER JOIN beneficiarioProyecto b ON r.id_beneficiario = b.id_beneficiario
                  WHERE d.id_restaurante = ? AND r.estado = 'activa'
                  ORDER BY r.fecha_reserva DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_restaurante);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }


    public function getReservaById($id_reserva, $id_restaurante)
    {
        $query = "SELECT r.*, d.id_donacion, d.nombre_descripcion, d.fecha_disponible, d.hora_limite,
                         b.nombre_completo, b.cedula_identidad, b.telefono, b.direccion
                  FROM reservaProyecto r
                  INNER JOIN donacionProyecto d ON r.id_donacion = d.id_donacion
                  INNER JOIN beneficiarioProyecto b ON r.id_beneficiario = b.id_beneficiario
                  WHERE r.id_reserva = ? AND d.id_restaurante = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $id_reserva, $id_restaurante);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function confirmarEntrega($id_reserva, $id_restaurante)
    {
        $queryCheck = "SELECT r.id_reserva, d.id_donacion 
                       FROM reservaProyecto r
                       INNER JOIN donacionProyecto d ON r.id_donacion = d.id_donacion
                       WHERE r.id_reserva = ? AND d.id_restaurante = ? AND r.estado = 'activa'";
        $stmtCheck = $this->conn->prepare($queryCheck);
        $stmtCheck->bind_param("ii", $id_reserva, $id_restaurante);
        $stmtCheck->execute();
        $result = $stmtCheck->get_result();

        if ($result->num_rows === 0) {
            return false;
        }

        $reserva = $result->fetch_assoc();

        $query = "UPDATE reservaProyecto SET estado = 'confirmada' WHERE id_reserva = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_reserva);
        $stmt->execute();

        $queryDonacion = "UPDATE donacionProyecto SET estado = 'agotado' WHERE id_donacion = ?";
        $stmtDonacion = $this->conn->prepare($queryDonacion);
        $stmtDonacion->bind_param("i", $reserva['id_donacion']);
        $stmtDonacion->execute();

        return $stmt->affected_rows > 0;
    }
    public function cancelarReserva($id_reserva, $id_restaurante)
    {
        $queryCheck = "SELECT r.id_reserva, d.id_donacion 
                       FROM reservaProyecto r
                       INNER JOIN donacionProyecto d ON r.id_donacion = d.id_donacion
                       WHERE r.id_reserva = ? AND d.id_restaurante = ? AND r.estado = 'activa'";
        $stmtCheck = $this->conn->prepare($queryCheck);
        $stmtCheck->bind_param("ii", $id_reserva, $id_restaurante);
        $stmtCheck->execute();
        $result = $stmtCheck->get_result();

        if ($result->num_rows === 0) {
            return false;
        }

        $reserva = $result->fetch_assoc();

        $query = "UPDATE reservaProyecto SET estado = 'cancelada' WHERE id_reserva = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_reserva);
        $stmt->execute();

        $queryDonacion = "UPDATE donacionProyecto SET estado = 'disponible' WHERE id_donacion = ?";
        $stmtDonacion = $this->conn->prepare($queryDonacion);
        $stmtDonacion->bind_param("i", $reserva['id_donacion']);
        $stmtDonacion->execute();

        return $stmt->affected_rows > 0;
    }

    public function eliminarReservasByRestaurante($id_restaurante)
    {
        $query = "DELETE r FROM reservaProyecto r
                  INNER JOIN donacionProyecto d ON r.id_donacion = d.id_donacion
                  WHERE d.id_restaurante = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_restaurante);
        $stmt->execute();
        return $stmt->affected_rows;
    }

    public function eliminarDonacionesByRestaurante($id_restaurante)
    {
        $query = "DELETE FROM donacionProyecto WHERE id_restaurante = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_restaurante);
        $stmt->execute();
        return $stmt->affected_rows;
    }

    public function eliminarCuenta($id_restaurante, $id_usuario)
    {
        $queryHorarios = "DELETE FROM horarioProyecto WHERE id_restaurante = ?";
        $stmtHorarios = $this->conn->prepare($queryHorarios);
        $stmtHorarios->bind_param("i", $id_restaurante);
        $stmtHorarios->execute();

        $this->eliminarReservasByRestaurante($id_restaurante);
        $this->eliminarDonacionesByRestaurante($id_restaurante);

        $queryRestaurante = "DELETE FROM restauranteProyecto WHERE id_restaurante = ?";
        $stmtRestaurante = $this->conn->prepare($queryRestaurante);
        $stmtRestaurante->bind_param("i", $id_restaurante);
        $stmtRestaurante->execute();

        return true;
    }

    public function contar()
    {
        $sql = "SELECT COUNT(*) as total FROM restauranteProyecto";
        $result = $this->conn->query($sql);
        return $result->fetch_assoc();
    }

    public function contarActivos()
    {
        $sql = "SELECT COUNT(DISTINCT r.id_restaurante) as total
            FROM restauranteProyecto r
            INNER JOIN donacionProyecto d 
                ON r.id_restaurante = d.id_restaurante
            WHERE d.estado = 'disponible'";
        $result = $this->conn->query($sql);
        return $result->fetch_assoc();
    }

    public function contarInactivos()
    {
        $sql = "SELECT COUNT(DISTINCT r.id_restaurante) as total
            FROM restauranteProyecto r
            WHERE r.id_restaurante NOT IN (
                SELECT DISTINCT id_restaurante 
                FROM donacionProyecto 
                WHERE estado = 'disponible'
            )";
        $result = $this->conn->query($sql);
        return $result->fetch_assoc();
    }

    public function obtenerTodos()
    {
        $sql = "SELECT 
                r.id_restaurante,
                r.nombre_negocio,
                r.tipo_establecimiento,
                CONCAT(r.provincia, ', ', r.canton) AS ubicacion,
                COUNT(CASE WHEN d.estado = 'disponible' THEN 1 END) AS donaciones_activas
            FROM restauranteProyecto r
            LEFT JOIN donacionProyecto d 
                ON r.id_restaurante = d.id_restaurante
            GROUP BY r.id_restaurante";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>