<?php

/*
|
| Controlador tarea
|
| Este archivo contiene todas las operaciones relacionadas con la conexión
| entre el crud y la visual.
|
*/

//Se llama a la clase
header("Content-Type: application/json; charset=UTF-8");
require_once("../config/conexion.php");
require_once("../models/Tarea.php");
require_once("../models/Pedido.php");
require_once("../models/Operario.php");
require_once("../DAO/TareaModel.php");

$tareaModel = new TareaModel($conexion);
$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
    case 'GET':
        //Listar tareas
        $tareas = $tareaModel->listar();
        $respuesta = [];
        foreach ($tareas as $t)
        {
            $pedidoObj = $t->getPedido();
            $operarioObj = $t->getOperario();

            $respuesta[] = [
                'id_tarea' => $t->getIdTarea(),
                'descripcion' => $t->getDescripcion(),
                'estado' => $t->getEstado(),
                'id_pedido' => $pedidoObj ? $pedidoObj->getIdPedido() : null,
                'id_operario' => $operarioObj ? $operarioObj->getIdOperario() : null
            ];
        }
        echo json_encode($respuesta);
        break;

    //Guardar o actualizar tarea    
    case 'POST':
        //Guardar tarea
        $data = json_decode(file_get_contents("php://input"), true);

        $pedido = null;
        if (!empty($data['id_pedido'])) {
            $pedido = new Pedido();
            $pedido->setIdPedido($data['id_pedido']);
        }

        $operario = null;
        if (!empty($data['id_operario'])) {
            $operario = new Operario();
            $operario->setIdOperario($data['id_operario']);
        }

        $tarea = new Tarea(
            $data['id_tarea'] ?? null,
            $data['descripcion'] ?? '',
            $data['estado'] ?? 'Pendiente',
            $pedido,
            $operario
        );

        if (!empty($data['id_tarea'])){
            $exito = $tareaModel->actualizar($tarea);
        } else {
            $exito = $tareaModel->guardar($tarea);
        }

        echo json_encode(['success' => $exito]);
        break;

    case 'DELETE':
        //Eliminar tarea
        $id = $_GET['id_tarea'] ?? null;
        if ($id) {
            $exito = $tareaModel->eliminar($id);
            echo json_encode(['success' => $exito]);
        }
        break;
}

?>