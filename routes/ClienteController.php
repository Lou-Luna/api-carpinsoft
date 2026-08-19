<?php

/*
|
| Controlador cliente
|
| Este archivo contiene todas las operaciones relacionadas con la conexión
| entre el crud y la visual.
|
*/

//Se llama a la clase
header("Content-Type: application/json; charset=UTF-8");
require_once("../config/conexion.php");
require_once("../models/Cliente.php");
require_once("../DAO/ClienteModel.php");

$clienteModel = new ClienteModel($conexion);
$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
    case 'GET':
        //Listar clientes
        $clientes = $clienteModel->listar();
        $respuesta = [];
        foreach ($clientes as $c)
        {
            $respuesta[] = [
                'id' => $c->getIdCliente(),
                'nombre' => $c->getNombre(),
                'contacto' => $c->getContacto(),
                'direccion' => $c->getDireccion()
            ];
        }
        echo json_encode($respuesta);
        break;

    //Guardar o actualizar cliente    
    case 'POST':
        //Guardar cliente
        $data = json_decode(file_get_contents("php://input"), true);

        $cliente = new Cliente(
            $data['id_cliente'] ?? null,
            $data['nombre'] ?? '',
            $data['contacto'] ?? '',
            $data['direccion'] ?? ''
        );

        if (!empty($data['id_cliente'])){
            $exito = $clienteModel->actualizar($cliente);
        } else {
            $exito = $clienteModel->guardar($cliente);
        }

        echo json_encode(['success' => $exito]);
        break;

        case 'DELETE':
        //Eliminar cliente
        $id = $_GET['id_cliente'] ?? null;
        if ($id) {
            $exito = $clienteModel->eliminar($id);
            echo json_encode(['success' => $exito]);
        }
        break;
}

?>