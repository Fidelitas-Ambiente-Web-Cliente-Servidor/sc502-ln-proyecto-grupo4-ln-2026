<?php
class Reserva
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function crear($id_donacion, $id_beneficiario)
    {
        // Generar codigo unico de reserva
        $codigo = 'ALM-' . date('Y') . '-' . str_pad($id_donacion, 3, '0', STR_PAD_LEFT) . '-' . rand(100, 999);

        $query = "INSERT INTO reservaProyecto (id_donacion, id_beneficiario, codigo_reserva, estado)
                  VALUES (?, ?, ?, 'activa')";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iis", $id_donacion, $id_beneficiario, $codigo);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Cambiar estado de la donacion a reservado
            $this->actualizarEstadoDonacion($id_donacion, 'reservado');
            return $codigo;
        }
        return false;
    }

    public function actualizarEstadoDonacion($id_donacion, $estado)
    {
        $query = "UPDATE donacionProyecto SET estado = ? WHERE id_donacion = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("si", $estado, $id_donacion);
        $stmt->execute();
    }

    public function beneficiarioYaReservo($id_donacion, $id_beneficiario)
    {
        $query = "SELECT id_reserva FROM reservaProyecto 
                  WHERE id_donacion = ? AND id_beneficiario = ? AND estado = 'activa'";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $id_donacion, $id_beneficiario);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    public function getReservasByBeneficiario($id_beneficiario)
    {
        $query = "SELECT r.id_reserva, r.codigo_reserva, r.estado,
                         d.nombre_descripcion, d.fecha_disponible, d.hora_limite,
                         res.nombre_negocio, res.provincia, res.canton
                  FROM reservaProyecto r
                  INNER JOIN donacionProyecto d ON r.id_donacion = d.id_donacion
                  INNER JOIN restauranteProyecto res ON d.id_restaurante = res.id_restaurante
                  WHERE r.id_beneficiario = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_beneficiario);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function confirmarReserva($id_reserva, $id_beneficiario)
    {
        $query = "UPDATE reservaProyecto SET estado = 'confirmada' 
                  WHERE id_reserva = ? AND id_beneficiario = ? AND estado = 'activa'";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $id_reserva, $id_beneficiario);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    public function cancelarReserva($id_reserva, $id_beneficiario)
    {
        // Hay que traer el id_donacion antes de cancelar
        $query = "SELECT id_donacion FROM reservaProyecto 
                  WHERE id_reserva = ? AND id_beneficiario = ? AND estado = 'activa'";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $id_reserva, $id_beneficiario);
        $stmt->execute();
        $result = $stmt->get_result();
        $reserva = $result->fetch_assoc();

        if (!$reserva) {
            return false;
        }

        // Se cancela la reserva
        $query2 = "UPDATE reservaProyecto SET estado = 'cancelada' WHERE id_reserva = ?";
        $stmt2 = $this->conn->prepare($query2);
        $stmt2->bind_param("i", $id_reserva);
        $stmt2->execute();

        if ($stmt2->affected_rows > 0) {
            // Volver la donacion a disponible
            $this->actualizarEstadoDonacion($reserva['id_donacion'], 'disponible');
            return true;
        }
        return false;
    }

    public function eliminarReservasByBeneficiario($id_beneficiario)
    {
        $query = "DELETE FROM reservaProyecto WHERE id_beneficiario = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_beneficiario);
        $stmt->execute();
        return $stmt->affected_rows;
    }

    public function cancelarReservasByBeneficiario($id_beneficiario)
    {
        // Solo se trae las reservas ACTIVAS para devolver las donaciones
        $query = "SELECT id_donacion FROM reservaProyecto 
              WHERE id_beneficiario = ? AND estado = 'activa'";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_beneficiario);
        $stmt->execute();
        $result = $stmt->get_result();
        $reservas = $result->fetch_all(MYSQLI_ASSOC);

        // Devolver solo las donaciones activas a disponible
        foreach ($reservas as $r) {
            $this->actualizarEstadoDonacion($r['id_donacion'], 'disponible');
        }

        // Cancelar solo las reservas activas
        $query2 = "UPDATE reservaProyecto SET estado = 'cancelada' 
               WHERE id_beneficiario = ? AND estado = 'activa'";
        $stmt2 = $this->conn->prepare($query2);
        $stmt2->bind_param("i", $id_beneficiario);
        $stmt2->execute();
    }

}