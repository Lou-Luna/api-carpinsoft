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
require_once("../models/Proveedor.php");

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

    if (!$stmt) {
        return false;
    }

    $nombre = $material->getNombre();
    $cantidad = (int) $material->getCantidad();
    
    $proveedorObj = $material->getProveedor();
    $idProveedor = ($proveedorObj && $proveedorObj->getIdProveedor()) ? (int)$proveedorObj->getIdProveedor() : null;

    if (empty($idProveedor)) {
        return false;
    }

    //Asociar parametros
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
    //Consulta SQL
    $sql = "SELECT 
                m.id_material, 
                m.nombre AS nombre_material, 
                m.cantidad, 
                m.id_proveedor, 
                p.nombre AS nombre_proveedor
            FROM material m
            LEFT JOIN proveedor p ON m.id_proveedor = p.id_proveedor";

    //Obtener resultado
    $resultado = $this->conexion->query($sql);

    $materiales = [];

    while($fila = $resultado->fetch_assoc())
        {
            $proveedor = new Proveedor(); 
            $proveedor->setIdProveedor($fila["id_proveedor"]);

            if (isset($fila["nombre_proveedor"])) {
            $proveedor->setNombre($fila["nombre_proveedor"]);
          }

            $material = new Material();

            $material->setIdMaterial($fila["id_material"]);
            $material->setNombre($fila["nombre_material"]);
            $material->setCantidad($fila["cantidad"]);

            $material->setProveedor($proveedor);

            $materiales[] = $material;
        }

        return $materiales;
}

/**
 * Buscar un material.
 *
 * @param int $id
 * @return Material
 */

public function buscarPorId($id)
{
    //Consulta SQL
    $sql  = "SELECT * FROM material WHERE id_material = ?";

    //Preparar sentencia
    $stmt = $this->conexion->prepare($sql);

    //Asociar parametro
    $stmt->bind_param("i", $id);

    //Ejecutar
    $stmt->execute();

    //Obtener resultado
    $resultado = $stmt->get_result();

    if($fila = $resultado->fetch_assoc())
        {
            $proveedor = new Proveedor();
            $proveedor->setIdProveedor($fila["id_proveedor"]);

            $material = new Material();

            $material->setIdMaterial($fila["id_material"]);
            $material->setNombre($fila["nombre_material"]);
            $material->setCantidad($fila["cantidad"]);
            $material->setProveedor($proveedor);

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
    //Sentencia SQL
    $sql = "UPDATE material SET nombre = ?, cantidad = ?, id_proveedor = ? WHERE id_material = ?";

    //Preparar sentencia
    $stmt = $this->conexion->prepare($sql);

    if (!$stmt) {
        return false;
    }

    $nombre = $material->getNombre();
    $cantidad = (int) $material->getCantidad();
    
    // Extraer el ID del proveedor de manera segura
    $proveedorObj = $material->getProveedor();
    $idProveedor = ($proveedorObj && $proveedorObj->getIdProveedor()) ? (int)$proveedorObj->getIdProveedor() : null;
    
    $id = (int) $material->getIdMaterial();

    // Validar que exista un id_proveedor válido para no romper la foreign key
    if (empty($idProveedor)) {
        return false;
    }
    //Asociar parametros
    $stmt->bind_param("siii", $nombre, $cantidad, $idProveedor, $id);

    //Ejecutar
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
    //Sentencia SQL
    $sql = "DELETE FROM material WHERE id_material = ?";

    //Prepapar sentencia
    $stmt = $this->conexion->prepare($sql);

    //Asociar parametro
    $stmt->bind_param("i",$id);

    //Ejecutar
    return $stmt->execute();
}

}    

?>