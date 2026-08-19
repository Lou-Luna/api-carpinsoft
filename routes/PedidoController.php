<?php

/*
|
| Controlador pedido
|
| Este archivo contiene todas las operaciones relacionadas con la conexión
| entre el crud y la visual.
|
*/

//Se llama a la clase
header("Content-Type: application/json; charset=UTF-8");
require_once("../config/conexion.php");
require_once("../models/Pedido.php");
require_once("../models/Cliente.php");
require_once("../DAO/PedidoModel.php");

$pedidoModel = new PedidoModel($conexion);
$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
    case 'GET':
        //Listar pedidos
        $pedidos = $pedidoModel->listar();
        $respuesta = [];
        foreach ($pedidos as $p)
        {
            $clienteObj = $p->getProveedor();

            $respuesta[] = [
                'id_pedido' => $p->getIdPedido(),
                'fecha' => $p->getFecha(),
                'estado' => $p->getEstado(),
                'especificacion' => $p->getEspecificacion(),
                'id_cliente' => $clienteObj ? $clienteObj->getIdCliente() : null
            ];
        }
        echo json_encode($respuesta);
        break;

    //Guardar o actualizar pedido    
    case 'POST':
        //Guardar pedido
        $data = json_decode(file_get_contents("php://input"), true);

        $cliente = null;
        if (!empty($data['id_cliente'])) {
            $cliente = new Cliente();
            $cliente->setIdCliente($data['id_cliente']);
        }

        $pedido = new Pedido(
            $data['id_pedido'] ?? null,
            $data['fecha'] ?? '',
            $data['estado'] ?? '',
            $data['especificacion'] ?? '',
            $cliente
        );

        if (!empty($data['id_pedido'])){
            $exito = $pedidoModel->actualizar($pedido);
        } else {
            $exito = $pedidoModel->guardar($pedido);
        }

        echo json_encode(['success' => $exito]);
        break;

    case 'DELETE':
        //Eliminar pedido
        $id = $_GET['id_pedido'] ?? null;
        if ($id) {
            $exito = $pedidoModel->eliminar($id);
            echo json_encode(['success' => $exito]);
        }
        break;  
}

?>