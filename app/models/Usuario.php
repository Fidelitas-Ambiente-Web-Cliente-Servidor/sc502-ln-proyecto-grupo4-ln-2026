<?php
class Usuario
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Busca usuario por correo, se trae tambien el rol y datos de perfil
    public function buscarPorCorreo($correo)
    {
        $query = "SELECT u.id_usuario, u.correo, u.contrasena, r.nombre AS rol
                  FROM usuarioProyecto u
                  INNER JOIN rolProyecto r ON u.id_rol = r.id_rol
                  WHERE u.correo = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Crea el usuario base (retorna el id_usuario insertado)
    public function crearUsuario($correo, $contrasena, $id_rol)
    {
        $query = "INSERT INTO usuarioProyecto (correo, contrasena, id_rol) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssi", $correo, $contrasena, $id_rol);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return $stmt->insert_id;
        }
        return false;
    }

    // Verifica si un correo ya existe
    public function correoExiste($correo)
    {
        $query = "SELECT id_usuario FROM usuarioProyecto WHERE correo = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    public function guardarToken($correo, $token, $expira)
    {
        $query = "UPDATE usuarioProyecto SET token_recuperacion = ?, token_expira = ? WHERE correo = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sss", $token, $expira, $correo);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    public function buscarPorToken($token)
    {
        $query = "SELECT * FROM usuarioProyecto WHERE token_recuperacion = ? AND token_expira > NOW()";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function actualizarContrasena($id_usuario, $contrasena)
    {
        $query = "UPDATE usuarioProyecto SET contrasena = ?, token_recuperacion = NULL, token_expira = NULL WHERE id_usuario = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("si", $contrasena, $id_usuario);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    public function actualizarCorreo($id_usuario, $correo)
    {
        $query = "UPDATE usuarioProyecto SET correo = ? WHERE id_usuario = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("si", $correo, $id_usuario);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    public function eliminar($id_usuario)
    {
        $query = "DELETE FROM usuarioProyecto WHERE id_usuario = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    public function eliminarNotificaciones($id_usuario)
    {
        $query = "DELETE FROM notificacionProyecto WHERE id_usuario = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        return $stmt->affected_rows;
    }

    public function obtenerPorId($id_usuario) {
    $sql = "SELECT u.correo, b.nombre_completo, b.cedula_identidad, b.telefono
            FROM usuarioProyecto u
            LEFT JOIN beneficiarioProyecto b 
                ON u.id_usuario = b.id_usuario
            WHERE u.id_usuario = $id_usuario";

    $result = $this->conn->query($sql);
    return $result->fetch_assoc();
}

}