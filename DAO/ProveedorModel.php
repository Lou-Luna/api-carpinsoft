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
    $sql = "SELECT * FROM proveedor";

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
    $sql = "SELECT * FROM proveedor WHERE id_proveedor = ?";

    $stmt = $this->conexion->prepare($sql);

    $stmt->bind_param("i", $id);

    $stmt->execute();

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
    $sql = "UPDATE proveedor SET nombre = ?, contacto = ? WHERE id_proveedor = ?";

    $stmt = $this->conexion->prepare($sql);

    $nombre = $proveedor->getNombre();
    $contacto = $proveedor->getContacto();
    $id = $proveedor->getIdProveedor();

    $stmt->bind_param("ssi", $nombre, $contacto, $id);

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
    $sql = "DELETE FROM proveedor WHERE id_proveedor = ?";

    $stmt = $this->conexion->prepare($sql);

    $stmt->bind_param("i",$id);

    return $stmt->execute();
}

}

?>