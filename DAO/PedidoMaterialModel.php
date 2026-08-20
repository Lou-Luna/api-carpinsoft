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

class PedidoMaterialModel{
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
    $sql = "INSERT INTO pedido_material (id_pedido, id_material, cantidad_usada) VALUES (?, ?, ?)";

    //Preparar sentencia
    $stmt = $this->conexion->prepare($sql);

    //Asociar parametros
    $stmt->bind_param("iii", $idPedido, $idMaterial, $cantidadUsada);

    //Ejecutar 
    return $stmt->execute();
}

/**
 * Listar materiales asociados a un pedido.
 *
 * @param int 
 * @return array
 */
public function listarPorPedido($idPedido)
{
    //Sentencia SQL
    $sql = "SELECT m.id_material, m.nombre, pm.cantidad_usada FROM material m INNER JOIN pedido_material pm ON m.id_material = pm.id_material WHERE pm.id_pedido = ?";

    //Preprar sentencia 
    $stmt = $this->conexion->prepare($sql);

    //Asociar parametro
    $stmt->bind_param("i", $idPedido);

    //Ejecutar
    $stmt->execute();

    //Obtener resultado
    $resultado = $stmt->get_result();

     $materiales = [];

    while($fila = $resultado->fetch_assoc()) {
            $material = new Material();
            $material->setIdMaterial($fila["id_material"]);
            $material->setNombre($fila["nombre"]);

            $pedido = new Pedido();
            $pedido->setIdPedido($idPedido);

            $pm = new PedidoMaterial($pedido, $material, $fila["cantidad_usada"]);
            $lista[] = $pm;
        }
        return $lista;
}

/**
     * Actualizar la cantidad usada de un material en un pedido.
     *
     * @param int 
     * @param int 
     * @param int 
     * @return bool
     */
public function actualizar($idPedido, $idMaterial, $cantidadUsada) {

    // Sentencia SQL
    $sql = "UPDATE pedido_material SET cantidad_usada = ? WHERE id_pedido = ? AND id_material = ?";

    // Preparar sentencia
    $stmt = $this->conexion->prepare($sql);

    // Asociar parámetros
    $stmt->bind_param("iii", $cantidadUsada, $idPedido, $idMaterial);
    
    // Ejecutar
    return $stmt->execute();
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