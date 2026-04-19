<?php
class Donacion 
{
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

    public function getDonacionesDisponiblesRestaurante() {
        $query = "SELECT d.id_donacion as 'idDonacion', d.nombre_descripcion 'nombre', d.tipo_alimento as 'tipoAlimento', 
                         d.cantidad as 'cantidad', d.descripcion_adicional 'descripcion', d.informacion_importante as 'informacion',
                         d.fecha_disponible as 'fechaDisponible', d.hora_limite as 'horaLimite', d.estado as 'estado',
                         r.nombre_negocio as 'nombreRestaurante', r.provincia as 'provincia', r.canton as 'canton'
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

    //Crea una nueva donacion
    public function nuevaDonacion($restauranteId,$tipoAlimento, $nombreDescripcion, $cantidad, $descripcionAdicional,$informacionImportante,
    $fechaDisponible,$horaLimite,$estado)
    {
        $query="INSERT INTO donacionProyecto
            (id_restaurante,tipo_alimento,nombre_descripcion,cantidad,descripcion_adicional,informacion_importante,fecha_disponible,hora_limite,estado)
            VALUES (?,?,?,?,?,?,?,?,?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("issssssss", $restauranteId,$tipoAlimento, $nombreDescripcion, $cantidad, $descripcionAdicional,$informacionImportante,
        $fechaDisponible,$horaLimite,$estado);
        $stmt->execute();
         if ($stmt->affected_rows > 0) {
            return $stmt->insert_id;
        }
        return false;
    }

    public function getDetalleDonacion($id_donacion) {
        $query = "SELECT d.id_donacion as 'idDonacion', d.tipo_alimento as 'tipoAlimento', d.nombre_descripcion as 'nombre',
        d.cantidad as 'cantidad', d.descripcion_adicional as 'descripcionAdicional', d.estado as 'estado',
        d.fecha_disponible as 'fechaDisponible',d.hora_limite as 'horaLimite',d.informacion_importante as 'informacionImportante',
        r.nombre_negocio as 'restaurante', r.provincia as 'provincia', r.canton as 'canton', r.distrito as 'distrito', 
        r.direccion_exacta as 'direccion'
                  FROM donacionProyecto d
                  INNER JOIN restauranteProyecto r ON d.id_restaurante = r.id_restaurante
                  WHERE d.id_donacion = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_donacion);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function cambiarEstado($idDonacion, $estado)
    {
            $query="UPDATE donacionProyecto set estado=? WHERE id_donacion=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("si", $estado,$idDonacion);
        $stmt->execute();
         if ($stmt->affected_rows > 0) {
            return true;
        }
        return false;
    }



}