<?php
class Restaurante {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function crear($id_usuario, $datos) {
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

    public function guardarHorarios($id_restaurante, $horarios) {
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
}