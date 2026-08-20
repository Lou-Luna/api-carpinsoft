<?php

/*
|
| Controlador pedido-material
|
| Este archivo contiene todas las operaciones relacionadas con la conexión
| entre el crud y la visual.
|
*/

//Se llama a la clase
header("Content-Type: application/json; charset=UTF-8");
require_once("../config/conexion.php");
require_once("../models/PedidoMaterial.php");
require_once("../models/Pedido.php");
require_once("../models/Material.php");
require_once("../DAO/PedidoMaterialModel.php");

$pedidoMaterialModel = new PedidoMaterialModel($conexion);
$metodo = $_SERVER['REQUEST_METHOD'];

//Listar relaciones
switch ($metodo){
    case 'GET':
        //Listar materiales asociados a un pedido
        $idPedido = $_GET['id_pedido'] ?? null;

        if ($idPedido) {
            $lista = $pmModel->listarPorPedido($idPedido);
        } else {
            $lista = $pmModel->listar();
        }

        $respuesta = [];
        foreach ($lista as $pm) {
            $pedidoObj = $pm->getPedido();
            $materialObj = $pm->getMaterial();

            $respuesta[] = [
                'id_pedido' => $pedidoObj ? $pedidoObj->getIdPedido() : null,
                'id_material' => $materialObj ? $materialObj->getIdMaterial() : null,
                'nombre_material' => $materialObj ? $materialObj->getNombre() : null,
                'cantidad_usada' => $pm->getCantidadUsada()
            ];
        }
        echo json_encode($respuesta);   
        break;

    //Guardar relación pedido-material
    case 'POST':
        $data = json_decode(file_get_contents("php:/input"),true);

        $pedido = new Pedido();
        $pedido->setIdPedido($data['id_pedido'] ?? null);

        $material = new Material();
        $material->setIdMaterial($data['id_material'] ?? null);

        $pedidoMaterial = new PedidoMaterial(
            $pedido,
            $material,
            $data['cantidad_usada'] ?? 0
        );

        // Si se envía un indicador de 'es_edicion', actualizar; si no, insertar
        if (!empty($data['es_edicion'])) {
            $exito = $pmModel->actualizar($pedidoMaterial);
        } else {
            $exito = $pmModel->guardar($pedidoMaterial);
        }

        echo json_encode(['success' => $exito]);
        break;

    //Eliminar relación pedido-material
    case 'DELETE':
        //Eliminar relacion
        $idPedido = $_GET['id_pedido'] ?? null;
        $idMaterial = $_GET['id_material'] ?? null;

        if ($idPedido && $idMaterial) {
            $exito = $pmModel->eliminar($idPedido, $idMaterial);
            echo json_encode(['success' => $exito]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Se requieren ambos IDs']);
        }
        break;
}

?>