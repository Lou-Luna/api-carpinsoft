<?php

/*
|
| Modelo pedido
|
| Esta clase contiene todas las operaciones relacionadas con la tabla
| pedido de la base de datos.
|
*/

//Se llama a la clase
require_once("../models/Pedido.php");
require_once("../models/Cliente.php");

class PedidoModel{
    private $conexion;
    public function __construct($conexion){
        $this->conexion = $conexion;
    }

/**
 * Guardar un pedido.
 *
 * @param Pedido $pedido
 * @return bool
 */

public function guardar(Pedido $pedido)
{
    //Sentencia SQL
    $sql = "INSERT INTO pedido(fecha, estado, especificacion, id_cliente) VALUES(?, ?, ?, ?)";

    //Preparar la consulta
    $stmt = $this->conexion->prepare($sql);

    $fecha = $pedido->getFecha();
    $estado = $pedido->getEstado();
    $especificacion = $pedido->getEspecificacion();
    $idCliente = $pedido->getCliente() ? $pedido->getCliente()->getIdCliente() : null;

    //Asociar parametros
    $stmt->bind_param("sssi", $fecha, $estado, $especificacion, $idCliente);

    //Ejecutar 
    return $stmt->execute();
}

/**
 * Listar pedidos.
 *
 * 
 * @return array
 */

public function listar()
{
    //Consulta SQL
    $sql = "SELECT * FROM pedido";

    //Obtener resultado
    $resultado = $this->conexion->query($sql);

    $pedidos = [];

    while($fila = $resultado->fetch_assoc())
        {
            $cliente = new Cliente(); 
            $cliente->setIdCliente($fila["id_cliente"]);

            $pedido = new Pedido();

            $pedido->setIdPedido($fila["id_pedido"]);
            $pedido->setFecha($fila["fecha"]);
            $pedido->setEstado($fila["estado"]);
            $pedido->setEspecificacion($fila["especificacion"]);
            $pedido->setCliente($cliente);

            $pedidos[] = $pedido;
        }

        return $pedidos;
}

/**
 * Buscar un pedido.
 *
 * @param int 
 * @return Pedido
 */

public function buscarPorId($id)
{
    //Consulta SQL
    $sql  = "SELECT * FROM pedido WHERE id_pedido = ?";

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
            $cliente = new Cliente();
            $cliente->setIdCliente($fila["id_cliente"]);

            $pedido = new Pedido();

            $pedido->setIdPedido($fila["id_pedido"]);
            $pedido->setFecha($fila["fecha"]);
            $pedido->setEstado($fila["estado"]);
            $pedido->setEspecificacion($fila["especificacion"]);
            $pedido->setCliente($cliente);

            return $pedido;
        }

        return null;
}

/**
 * Actualizar un pedido.
 *
 * @param Pedido $pedido
 * @return bool 
 */

public function actualizar(Pedido $pedido)
{
    //Sentencia SQL
    $sql = "UPDATE pedido SET fecha = ?, estado = ?, especificacion = ?, id_cliente = ? WHERE id_pedido = ?";

    //Preparar sentencia
    $stmt = $this->conexion->prepare($sql);

    $fecha = $pedido->getFecha();
    $estado = $pedido->getEstado();
    $especificacion = $pedido->getEspecificacion();
    $idCliente = $pedido->getCliente() ? $pedido->getCliente()->getIdCliente() : null;
    $id = $pedido->getIdPedido();

    //Asociar parametros
    $stmt->bind_param("sssii", $fecha, $estado, $especificacion, $idCliente, $id);

    //Ejecutar
    return $stmt->execute();
}

/**
 * Eliminar un pedido.
 *
 * @param int 
 * @return bool 
 */

public function eliminar($id)
{
    //Sentencia SQL
    $sql = "DELETE FROM pedido WHERE id_pedido = ?";

    //Prepapar sentencia
    $stmt = $this->conexion->prepare($sql);

    //Asociar parametro
    $stmt->bind_param("i",$id);

    //Ejecutar
    return $stmt->execute();
}

}
?>    