<?php
class Beneficiario {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function crear($id_usuario, $datos) {
        $query = "INSERT INTO beneficiarioProyecto
                    (id_usuario, nombre_completo, cedula_identidad, telefono,
                     provincia, canton, direccion, fecha_nacimiento)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param(
            "isssssss",
            $id_usuario,
            $datos['nombre_completo'],
            $datos['cedula_identidad'],
            $datos['telefono'],
            $datos['provincia'],
            $datos['canton'],
            $datos['direccion'],
            $datos['fecha_nacimiento']
        );
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
}