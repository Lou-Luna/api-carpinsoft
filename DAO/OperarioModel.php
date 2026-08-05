<?php

/*
|
| Modelo operario
|
| Esta clase contiene todas las operaciones relacionadas con la tabla
| operario de la base de datos.
|
*/

//Se llama a la clase
require_once("../models/Operario.php");

class Operario{
    private $conexion;
    public function __construct($conexion){
        $this->conexion = $conexion;
    }

/**
 * Guardar un operario.
 *
 * @param Operario $operario
 * @return bool
 */

public function guardar(Operario $operario)
{
    //Sentencia SQL
    $sql = "INSERT INTO operario(nombre, rol) VALUES(?, ?)";

    //Preparar la consulta
    $stmt = $this->conexion->prepare($sql);

    $nombre = $operario->getNombre();
    $rol = $operario->getOperario();

    //Asociar parametros
    $stmt->bind_param("ss", $nombre, $rol);

    //Ejecutar 
    return $stmt->execute();
}

/**
 * Listar operarios.
 *
 * 
 * @return array
 */

public function listar()
{
    //Sentencia SQL
    $sql = "SELECT * FROM operario";

    //Obtener resultado
    $resultado = $this->conexion->query($sql);

    $operarios = [];

    while($fila = $resultado->fetch_assoc())
        {
            $operario = new Operario();

            $operario->setIdOperario($fila["id_operario"]);
            $operario->setNombre($fila["nombre"]);
            $operario->setRol($fila["rol"]);

            $operarios[] = $operario;
        }

        return $operarios;
}

/**
 * Buscar un operario.
 *
 * @param int 
 * @return Operario
 */

public function buscarPorId($id)
{
    //Sentencia SQL
    $sql = "SELECT * FROM operario WHERE id_operario = ?";

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
            $operario = new Operario();

            $operario->setIdOperario($fila["id_operario"]);
            $operario->setNombre($fila["nombre"]);
            $operario->setRol($fila["rol"]);

            return $operario;
        }

        return null;
}

/**
 * Actualizar un operario.
 *
 * @param Operario $operario
 * @return bool 
 */

public function actualizar(Operario $operario)
{
    //Sentencia SQL
    $sql = "UPDATE operario SET nombre = ?, rol = ? WHERE id_operario = ?";

    //Preparar sentencia
    $stmt = $this->conexion->prepare($sql);

    $nombre = $operario->getNombre();
    $rol = $operario->getRol();
    $id = $operario->getIdOperario();

    //Asociar papametros
    $stmt->bind_param("ssi", $nombre, $rol, $id);

    return $stmt->execute();
}

/**
 * Eliminar un operario.
 *
 * @param int 
 * @return bool 
 */

public function eliminar($id)
{
    //Sentencia SQl
    $sql = "DELETE FROM operario WHERE id_operario = ?";

    //Preparar sentencia
    $stmt = $this->conexion->prepare($sql);

    //Asociar papametro
    $stmt->bind_param("i",$id);

    //Ejecutar
    return $stmt->execute();
}

}

?>