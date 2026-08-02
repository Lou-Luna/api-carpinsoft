<?php

/*
|
| Modelo material
|
| Esta clase contiene todas las operaciones relacionadas con la tabla
| material de la base de datos.
|
*/

//Se llama a la clase
require_once("../models/Material.php");

class MaterialModel{
    private $conexion;
    public function __construct($conexion){
        $this->conexion = $conexion;
    }

/**
 * Guardar un material.
 *
 * @param Material $material
 * @return bool
 */

public function guardar(Material $material)
{
    //Sentencia SQL
    $sql = "INSERT INTO material(nombre, cantidad, id_proveedor) VALUES(?, ?, ?)";

    //Preparar la consulta
    $stmt = $this->conexion->prepare($sql);

    $nombre = $material->getNombre();
    $cantidad = $material->getCantidad();
    $idProveedor = $material->getIdProveedor();

    $stmt->bind_param("sii", $nombre, $cantidad, $idProveedor);

    //Ejecutar 
    return $stmt->execute();
}

/**
 * Listar materiales.
 *
 * 
 * @return array
 */

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

/**
 * Buscar un material.
 *
 * @param int 
 * @return Material
 */

public function buscarPorId($id)
{
    $sql  = "SELECT * FROM material WHERE id_materiall = ?";

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

/**
 * Actualizar un material.
 *
 * @param Material $material
 * @return bool 
 */

public function actualizar(Material $material)
{
    $sql = "UPDATE material SET nombre = ?, cantidad = ?, id_proveedor = ? WHERE id_material = ?";

    $stmt = $this->conexion->prepare($sql);

    $nombre = $material->getNombre();
    $cantidad = $material->getCantidad();
    $idProveedor = $material->getIdProveedor();
    $id = $material->getIdMaterial();

    $stmt->bind_param("siii", $nombre, $cantidad, $idProveedor, $id);

    return $stmt->execute();
}

/**
 * Eliminar un material.
 *
 * @param int 
 * @return bool 
 */

public function eliminar($id)
{
    $sql = "DELETE FROM material WHERE id_material = ?";

    $stmt = $this->conexion->prepare($sql);

    $stmt->bind_param("i",$id);

    return $stmt->execute();
}

}    

?>