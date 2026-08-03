<?php

/*
|
| Modelo proveedor
|
| Esta clase contiene todas las operaciones relacionadas con la tabla
| proveedor de la base de datos.
|
*/

//Se llama a la clase
require_once("../models/Proveedor.php");

class ProveedorModel{

    private $conexion;
    public function __construct($conexion){
        $this->conexion = $conexion;
    }

/**
 * Guardar un proveedor.
 *
 * @param Provedeedor $proveedor
 * @return bool
 */

public function guardar(Proveedor $proveedor)
{
    //Sentencia SQL
    $sql = "INSERT INTO proveedor(nombre, contacto) VALUES(?, ?)";

    //Preparar la consulta
    $stmt = $this->conexion->prepare($sql);

    $nombre = $proveedor->getNombre();
    $contacto = $proveedor->getContacto();

    //Asociar parametros
    $stmt->bind_param("ss", $nombre, $contacto);

    //Ejecutar 
    return $stmt->execute();
}

/**
 * Listar proveedores.
 *
 * 
 * @return array
 */

public function listar()
{
    //Sentencia SQL
    $sql = "SELECT * FROM proveedor";

    //Obtener resultado
    $resultado = $this->conexion->query($sql);

    $proveedores = [];

    while($fila = $resultado->fetch_assoc())
        {
            $proveedor = new Proveedor();

            $proveedor->setIdProveedor($fila["id_proveedor"]);
            $proveedor->setNombre($fila["nombre"]);
            $proveedor->setContacto($fila["contacto"]);

            $proveedores[] = $proveedor;
        }

        return $proveedores;
}

/**
 * Buscar un proveedor.
 *
 * @param int 
 * @return Proveedor
 */

public function buscarPorId($id)
{
    //Sentencia SQL
    $sql = "SELECT * FROM proveedor WHERE id_proveedor = ?";

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
            $proveedor->setNombre($fila["nombre"]);
            $proveedor->setContacto($fila["contacto"]);

            return $proveedor;
        }

        return null;
}

/**
 * Actualizar un proveedor.
 *
 * @param Proveedor $proveedor
 * @return bool 
 */

public function actualizar(Proveedor $proveedor)
{
    //Sentencia SQL
    $sql = "UPDATE proveedor SET nombre = ?, contacto = ? WHERE id_proveedor = ?";

    //Preparar sentencia
    $stmt = $this->conexion->prepare($sql);

    $nombre = $proveedor->getNombre();
    $contacto = $proveedor->getContacto();
    $id = $proveedor->getIdProveedor();

    //Asociar parametros
    $stmt->bind_param("ssi", $nombre, $contacto, $id);

    //Ejecutar
    return $stmt->execute();
}

/**
 * Eliminar un proveedor.
 *
 * @param int 
 * @return bool 
 */

public function eliminar($id)
{
    //Sentencia SQL
    $sql = "DELETE FROM proveedor WHERE id_proveedor = ?";

    //Prepara sentencia
    $stmt = $this->conexion->prepare($sql);

    //Asociar parametro
    $stmt->bind_param("i",$id);

    //Ejecutar
    return $stmt->execute();
}

}

?>