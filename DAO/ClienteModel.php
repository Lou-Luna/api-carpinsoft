<?php

/*
|
| Modelo cliente
|
| Esta clase contiene todas las operaciones relacionadas con la tabla
| cliente de la base de datos.
|
*/

//Se llama a la clase
require_once("../models/Cliente.php");

class ClienteModel{
    private $conexion;
    public function __construct($conexion){
        $this->conexion = $conexion;
    }


/**
 * Guardar un cliente.
 *
 * @param Cliente $cliente
 * @return bool
 */

public function guardar(Cliente $cliente)
{
    //Sentencia SQL
    $sql = "INSERT INTO cliente(nombre, contacto, direccion) VALUES(?, ?, ?)";

    //Preparar la consulta
    $stmt = $this->conexion->prepare($sql);

    $nombre = $cliente->getNombre();
    $contacto = $cliente->getContacto();
    $direccion = $cliente->getDireccion();

    $stmt->bind_param("sss", $nombre, $contacto, $direccion);

    //Ejecutar 
    return $stmt->execute();
}

/**
 * Listar clientes.
 *
 * 
 * @return array
 */

public function listar()
{
    $sql = "SELECT * FROM cliente";

    $resultado = $this->conexion->query($sql);

    $clientes = [];

    while($fila = $resultado->fetch_assoc())
        {
            $cliente = new Cliente();

            $cliente->setIdCliente($fila["id_cliente"]);
            $cliente->setNombre($fila["nombre"]);
            $cliente->setContacto($fila["contacto"]);
            $cliente->setDireccion($fila["direccion"]);

            $clientes[] = $cliente;
        }

        return $clientes;
}

/**
 * Buscar un cliente.
 *
 * @param int 
 * @return Cliente
 */

public function buscarPorId($id)
{
    $sql = "SELECT * FROM cliente WHERE id_cliente = ?";

    $stmt = $this->conexion->prepare($sql);

    $stmt->bind_param("i", $id);

    $stmt->execute();

    $resultado = $stmt->get_result();

    if($fila = $resultado->fetch_assoc())
        {
            $cliente = new Cliente();

            $cliente->setIdCliente($fila["id_cliente"]);
            $cliente->setNombre($fila["nombre"]);
            $cliente->setContacto($fila["contacto"]);
            $cliente->setDireccion($fila["direccion"]);

            return $cliente;
        }

        return null;
}

/**
 * Actualizar un cliente.
 *
 * @param Cliente $cliente
 * @return bool 
 */

public function actualizar(Cliente $cliente)
{
    $sql = "UPDATE cliente SET nombre = ?, contacto = ?, direccion = ? WHERE id_cliente = ?";

    $stmt = $this->conexion->prepare($sql);

    $nombre = $cliente->getNombre();
    $contacto = $cliente->getContacto();
    $direccion = $cliente->getDireccion();
    $id = $cliente->getIdCliente();

    $stmt->bind_param("sssi", $nombre, $contacto, $direccion, $id);

    return $stmt->execute();
}

/**
 * Eliminar un cliente.
 *
 * @param int 
 * @return bool 
 */

public function eliminar($id)
{
    $sql = "DELETE FROM cliente WHERE id_cliente = ?";

    $stmt = $this->conexion->prepare($sql);

    $stmt->bind_param("i",$id);

    return $stmt->execute();
}

}

?>