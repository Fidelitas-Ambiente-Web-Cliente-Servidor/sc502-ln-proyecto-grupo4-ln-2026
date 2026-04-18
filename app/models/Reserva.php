<?php
class Reserva {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function crear($id_donacion, $id_beneficiario) {
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

    public function actualizarEstadoDonacion($id_donacion, $estado) {
        $query = "UPDATE donacionProyecto SET estado = ? WHERE id_donacion = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("si", $estado, $id_donacion);
        $stmt->execute();
    }

    public function beneficiarioYaReservo($id_donacion, $id_beneficiario) {
        $query = "SELECT id_reserva FROM reservaProyecto 
                  WHERE id_donacion = ? AND id_beneficiario = ? AND estado = 'activa'";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $id_donacion, $id_beneficiario);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }
}