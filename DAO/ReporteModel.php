<?php

/*
|
| Modelo reporte
|
| Esta clase contiene todas las operaciones relacionadas con la tabla
| reporte de la base de datos.
|
*/

//Se llama a la clase
require_once("../models/Reporte.php");
require_once("../models/Pedido.php");

class ReporteModel{
    private $conexion;
    public function __construct($conexion){
        $this->conexion = $conexion;
    }

/**
 * Guardar un reporte.
 *
 * @param Reporte $reporte
 * @return bool
 */

public function guardar(Reporte $reporte)
{
    //Sentencia SQL
    $sql = "INSERT INTO reporte(tipo, fecha, id_pedido) VALUES(?, ?, ?)";

    //Preparar la consulta
    $stmt = $this->conexion->prepare($sql);

    $tipo = $reporte->gettipo();
    $fecha = $reporte->getfecha();
    $idPedido = $reporte->getPedido() ? $reporte->getPedido()->getIdPedido() : null;

    //Asociar parametros
    $stmt->bind_param("ssi", $tipo, $fecha, $idPedido);

    //Ejecutar 
    return $stmt->execute();
}

/**
 * Listar reportes.
 *
 * 
 * @return array
 */

public function listar()
{
    //Consulta SQL
    $sql = "SELECT * FROM reporte";

    //Obtener resultado
    $resultado = $this->conexion->query($sql);

    $reportes = [];

    while($fila = $resultado->fetch_assoc())
        {
            $pedido = new pedido$pedido(); 
            $pedido->setIdPedido($fila["id_pedido"]);

            $reporte = new reporte();

            $reporte->setIdReporte($fila["id_reporte"]);
            $reporte->settipo($fila["tipo"]);
            $reporte->setfecha($fila["fecha"]);
            $reporte->setPedido($pedido;)

            $reportes[] = $reporte;
        }

        return $reportes;
}

/**
 * Buscar un reporte.
 *
 * @param int 
 * @return Reporte
 */

public function buscarPorId($id)
{
    //Consulta SQL
    $sql  = "SELECT * FROM reporte WHERE id_reporte = ?";

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
            $pedido->setIdpedido($fila["id_pedido"]);

            $reporte = new Reporte();

            $reporte->setIdreporte($fila["id_reporte"]);
            $reporte->settipo($fila["tipo"]);
            $reporte->setfecha($fila["fecha"]);
            $reporte->setPedido($pedido);

            return $reporte;
        }

        return null;
}

/**
 * Actualizar un reporte.
 *
 * @param Reporte $reporte
 * @return bool 
 */

public function actualizar(Reporte $reporte)
{
    //Sentencia SQL
    $sql = "UPDATE reporte SET tipo = ?, fecha = ?, id_pedido = ? WHERE id_reporte = ?";

    //Preparar sentencia
    $stmt = $this->conexion->prepare($sql);

    $tipo = $reporte->gettipo();
    $fecha = $reporte->getfecha();
    $idpedido$pedido = $reporte->getPedido() ? $reporte->getPedido()->getIdpedido() : null;
    $id = $reporte->getIdreporte();

    //Asociar parametros
    $stmt->bind_param("ssii", $tipo, $fecha, $idpedido, $id);

    //Ejecutar
    return $stmt->execute();
}

/**
 * Eliminar un reporte.
 *
 * @param int 
 * @return bool 
 */

public function eliminar($id)
{
    //Sentencia SQL
    $sql = "DELETE FROM reporte WHERE id_reporte = ?";

    //Prepapar sentencia
    $stmt = $this->conexion->prepare($sql);

    //Asociar parametro
    $stmt->bind_param("i",$id);

    //Ejecutar
    return $stmt->execute();
}

}    

?>