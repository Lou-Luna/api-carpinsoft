<?php

/*
|
| Controlador 
|
| Este archivo contiene todas las operaciones relacionadas con la conexión
| entre el crud y la visual.
|
*/

//Se llama a la clase

header("Content-Type: application/json; charset=UTF-8");
require_once("../config/conexion.php");
require_once("../models/Operario.php");
require_once("../DAO/OperarioModel.php");

$operarioModel = new OperarioModel($conexion);
$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
    Case 'GET':
        //Listar operarios
        $operarios = $operarioModel->listar();
        $respuesta = [];
        foreach ($operarios as $o)
        {
            $respuesta[] = [
                'id' => $o->getIdOperario(),
                'nombre' => $o->getNombre(),
                'rol' => $o->getRol()
            ];
        }
        echo json_encode($respuesta);
        break;

    //Guardar o actualizar operario
    case 'POST':
        //Guardar operario
        $data = json_decode(file_get_contents("php://input"), true);

        $operario = new Operario(
            $data['id_operario'] ?? null,
            $data['nombre'] ?? '',
            $data['rol'] ?? ''
        );

        if (!empty($data['id_operario'])){
            $exito = $operarioModel->actualizar($operario);
        } else {
            $exito = $operarioModel->guardar($operario);
        }

        echo json_encode(['success' => $exito]);
        break;

        case 'DELETE':
        //Eliminar operario
        $idOperario = $_GET['id_operario'] ?? null;
        if ($idOperario) {
            $exito = $operarioModel->eliminar($idOperario);
            echo json_encode(['success' => $exito]);
        }
        break;
}

?>