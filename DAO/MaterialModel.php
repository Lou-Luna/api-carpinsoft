<?php

/*
|
| Modelo material
|
| Esta clase contiene todas las operaciones relacionadas con la tabla
| material de la base de datos.
|
*/

require_once("../models/Material.php");

class MaterialModel{
    private $conexion;
    public function __construct($conexion){
        $this->conexion = $conexion;
    }

public function guardar(Material $material)
{
    //Sentencia SQL
    $sql = "INSERT INTO material(nombre, cantidad, id_proveedor) VALUES(?, ?, ?)";

    //Preparar la consulta
    $stmt = $this->conexion->prepare($sql);

    $nombre = $material->getNombre();
    $cantidad = $material->getCantidad();
    $idProveedor = $material->getIdProveedor();

    $stmt->bind_param("sss", $nombre, $cantidad, $idProveedor);

    //Ejecutar 
    return $stmt->execute();
}

public function listar()
{
    $sql = "SELECT * FROM material";

    $resultado = $this->conexion->query($sql);

    $materiales = [];

    while($fila = $resultado->fetch_assoc())
        {
            $material = new Material();

            $material->setIdMaterial($fila["id_material"]);
            $material->setNombre($fila["nombre"]);
            $material->setCantidad($fila["cantidad"]);
            $material->setIdProveedor($fila["id_proveedor"]);

            $materiales[] = $material;
        }

        return $materiales;
}

public function buscarPorId($id)
{
    $sql "SELECT * FROM material WHERE id_materail = ?";

    $stmt = $this->conexion->prepare($sql);

    $stmt->bind_param("i", $id);

    $stmt->execute();

    $resultado = $stmt->get_result();

    if($fila = $resultado->fetch_assoc())
        {
            $material = new Material();

            $material->setIdMaterial($fila["id_material"]);
            $material->setNombre($fila["nombre"]);
            $material->setCantidad($fila["cantidad"]);
            $material->setIdProveedor($fila["id_proveedor"]);

            return $material;
        }

        return null;
}

public function actualizar(Material $material)
{
    $sql = "UPDATE material SET nombre = ?, cantidad = ?, id_proveedor = ? WHERE id_material = ?";

    $stmt = $this->conexion->prepare($sql);

    $nombre = $material->getNombre();
    $cantidad = $material->getCantidad();
    $idProveedor = $material->getIdProveedor();
    $id = $material->getIdMaterial();

    $stmt->bind_param("sssi", $nombre, $cantidad, $idProveedor, $id);

    return $stmt->execute();
}

public function eliminar($id)
{
    $sql = "DELETE FROM material WHERE id_material = ?";

    $stmt = $this->conexion->prepare($sql);

    $stmt->bind_param("i",$id);

    return $stmt->execute();
}

}    