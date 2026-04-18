<?php
class Beneficiario
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function crear($id_usuario, $datos)
    {
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

    public function getByIdUsuario($id_usuario)
    {
        $query = "SELECT * FROM beneficiarioProyecto WHERE id_usuario = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function actualizar($id_beneficiario, $datos)
    {
        $query = "UPDATE beneficiarioProyecto 
              SET nombre_completo = ?, cedula_identidad = ?, telefono = ?,
                  provincia = ?, canton = ?, direccion = ?, fecha_nacimiento = ?
              WHERE id_beneficiario = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param(
            "sssssssi",
            $datos['nombre_completo'],
            $datos['cedula_identidad'],
            $datos['telefono'],
            $datos['provincia'],
            $datos['canton'],
            $datos['direccion'],
            $datos['fecha_nacimiento'],
            $id_beneficiario
        );
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    public function eliminar($id_beneficiario)
    {
        $query = "DELETE FROM beneficiarioProyecto WHERE id_beneficiario = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_beneficiario);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
}