<?php
class Donacion {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Trae todas las donaciones disponibles con datos del restaurante
    public function getDonacionesDisponibles() {
        $query = "SELECT d.id_donacion, d.nombre_descripcion, d.tipo_alimento, 
                         d.cantidad, d.descripcion_adicional, d.informacion_importante,
                         d.fecha_disponible, d.hora_limite, d.estado,
                         r.nombre_negocio, r.provincia, r.canton
                  FROM donacionProyecto d
                  INNER JOIN restauranteProyecto r ON d.id_restaurante = r.id_restaurante
                  WHERE d.estado = 'disponible'
                  AND d.fecha_disponible >= CURDATE()
                  ORDER BY d.fecha_disponible ASC, d.hora_limite ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Trae una donacion por id con los datos del restaurante
    public function getDonacionById($id_donacion) {
        $query = "SELECT d.*, r.nombre_negocio, r.provincia, r.canton, 
                         r.distrito, r.direccion_exacta, r.link_maps
                  FROM donacionProyecto d
                  INNER JOIN restauranteProyecto r ON d.id_restaurante = r.id_restaurante
                  WHERE d.id_donacion = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_donacion);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}