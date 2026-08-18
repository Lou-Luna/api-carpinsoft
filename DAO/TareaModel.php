<?php

/*
|
| Modelo tarea
|
| Esta clase contiene todas las operaciones relacionadas con la tabla
| tarea de la base de datos.
|
*/

//Se llama a la clase
require_once("../models/Pedido.php");
require_once("../models/Operario.php");

class TareaModel{
    private $conexion;
    public function __construct($conexion){
        $this->conexion = $conexion;
    }

/**
 * Guardar una tarea.
 *
 * @param Tarea $tarea
 * @return bool
 */

public function guardar(Tarea $tarea)
{
    //Sentencia SQL
    $sql = "INSERT INTO tarea(descripcion, estado, id_pedido, id_operario) VALUES(?, ?, ?, ?)";

    //Preparar la consulta
    $stmt = $this->conexion->prepare($sql);

    $descripcion = $tarea->getDescripcion();
    $estado = $tarea->getEstado();

    $idPedido = $tarea->getPedido() ? $tarea->getPedido()->getIdPedido() : null;
    $idOperario = $tarea->getOperario() ? $tarea->getOperario()->getIdOperario() : null;

    //Asociar parametros
    $stmt->bind_param("ssii", $descripcion, $estado, $idPedido, $idOperario);

    //Ejecutar 
    return $stmt->execute();
}

/**
 * Listar tareas.
 *
 * 
 * @return array
 */

public function listar()
{
    //Consulta SQL
    $sql = "SELECT * FROM tarea";

    //Obtener resultado
    $resultado = $this->conexion->query($sql);

    $tareas = [];

    while($fila = $resultado->fetch_assoc())
        {
            $pedido = new Pedido(); 
            $pedido->setIdPedido($fila["id_pedido"]);

            $operario = new Operario();
            $operario->setIdOperario($fila["id_operario"]);

            $tarea = new Tarea();

            $tarea->setIdtarea($fila["id_tarea"]);
            $tarea->setDescripcion($fila["descripcion"]);
            $tarea->setEstado($fila["estado"]);
            $tarea->setPedido($pedido);
            $tarea->setOperario($operario);

            $tareas[] = $tarea;
        }

        return $tareas;
}

/**
 * Buscar una tarea.
 *
 * @param int 
 * @return Tarea
 */

public function buscarPorId($id)
{
    //Consulta SQL
    $sql  = "SELECT * FROM tarea WHERE id_tarea = ?";

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
            $pedido = new Pedido();
            $pedido->setIdPedido($fila["id_pedido"]);

            $operario = new Operario();
            $operario->setIdOperario($fila["id_operario"]);

            $tarea = new Tarea();

            $tarea->setIdtarea($fila["id_tarea"]);
            $tarea->setEstado($fila["estado"]);
            $tarea->setDescripcion($fila["descripcion"]);
            $tarea->setPedido($pedido);
            $tarea->setOperario($operario);

            return $tarea;
        }

        return null;
}

/**
 * Actualizar una tarea.
 *
 * @param Tarea $tarea
 * @return bool 
 */

public function actualizar(Tarea $tarea)
{
    //Sentencia SQL
    $sql = "UPDATE tarea SET descripcion = ?, estado = ?, id_pedido = ?, id_operario = ? WHERE id_tarea = ?";

    //Preparar sentencia
    $stmt = $this->conexion->prepare($sql);

    $descripcion = $tarea->getDescripcion();
    $estado = $tarea->getEstado();
    $idPedido = $tarea->getPedido() ? $tarea->getPedido()->getIdPedido() : null;
    $idOperario = $tarea-getOperario() ? $tarea->getOperario()->getIdOperario() : null;
    $id = $tarea->getIdTarea();

    //Asociar parametros
    $stmt->bind_param("ssiii", $estado, $descripcion, $idPedido, $idOperario, $id);

    //Ejecutar
    return $stmt->execute();
}

/**
 * Eliminar un tarea.
 *
 * @param int 
 * @return bool 
 */

public function eliminar($id)
{
    //Sentencia SQL
    $sql = "DELETE FROM tarea WHERE id_tarea = ?";

    //Prepapar sentencia
    $stmt = $this->conexion->prepare($sql);

    //Asociar parametro
    $stmt->bind_param("i",$id);

    //Ejecutar
    return $stmt->execute();
}

}    

?>