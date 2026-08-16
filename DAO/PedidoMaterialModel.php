<?php

/*
|
| Modelo pedido-material
|
| Esta clase contiene todas las operaciones relacionadas con la tabla
| pedido-material de la base de datos.
|
*/

//Se llama a la clase
require_once("../models/PedidoMaterial.php");
require_once("../models/Pedido.php");
require_once("../models/Material.php");

class PedidoMaterial{
    private $conexion;
    public function __construct($conexion){
        $this->conexion = $conexion;
    }


/**
 * Guardar relación pedido-material.
 *
 * @param int 
 * @param int 
 * @param int
 * @return bool
 */
public function guardar($idPedido, $idMaterial, $cantidadUsada)
{
    //Sentencia SQL
    $sql = "INSERT INTO pedido_material (id_pedido, id_material, cantidad usada) VALUES (?, ?, ?)"

    //Preparar sentencia
    $stmt = $this->conexion->prepare($sql);

    //Asociar parametros
    $stmt->bind_param("iii", $idPedido, $idMaterial, $cantidadUsada);

    //Ejecutar 
    return $stmt->execute();
}

public function listarPorPedido($idPedido)
{
    //Sentencia SQL
    $sql = "SELECT m.* FROM material m INNER JOIN pedido_material pm ON m.id_material = pm.id_material WHERE pm.id_pedido = ?";

    //Preprar sentencia 
    $stmt = $this->conexion->prepare($sql);

    //Asociar parametro
    $stmt->bind_param("i", $idPedido);

    //Ejecutar
    $stmt->execute();

    //Obtener resultado
    $resultado = $stmt->get_result();

     $materiales = [];

    while($fila = $resultado->fetch_assoc()) 
        {
            $material = new Material();
            $material->setIdMaterial($fila["id_material"]);
            $material->setNombre($fila["nombre"]);
            $material->setCantidadUsada($fila["cantidad"]);
            $materiales[] = $material;
        }
        return $materiales;
}


/**
 * Eliminar una relación pedido-material.
 *
 * @param int 
 * @param int
 * @return bool 
 */

public function eliminar($idPedido, $idMaterial)
{
    //Sentencia SQL
    $sql = "DELETE FROM pedido_material WHERE id_pedido = ? AND id_material = ?";

    //Prepapar sentencia
    $stmt = $this->conexion->prepare($sql);

    //Asociar parametros
    $stmt->bind_param("ii",$idPedido, $idMaterial);

    //Ejecutar
    return $stmt->execute();
}

}

?>