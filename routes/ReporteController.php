<?php

/*
|
| Controlador reporte
|
| Este archivo contiene todas las operaciones relacionadas con la conexión
| entre el crud y la visual.
|
*/

//Se llama a la clase
header("Content-Type: application/json; charset=UTF-8");
require_once("../config/conexion.php");
require_once("../models/Reporte.php");
require_once("../models/Pedido.php");
require_once("../DAO/ReporteModel.php");

$reporteModel = new ReporteModel($conexion);
$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
    case 'GET':
        //Listar reportes
        $reportes = $reporteModel->listar();
        $respuesta = [];
        foreach ($reportes as $r)
        {
            $pedidoObj = $r->getPedido();

            $respuesta[] = [
                'id_reporte' => $r->getIdReporte(),
                'tipo' => $r->getTipo(),
                'fecha' => $r->getFecha(),
                'id_pedido' => $pedidoObj ? $pedidoObj->getIdPedido() : null
            ];
        }
        echo json_encode($respuesta);
        break;

    //Guardar o actualizar reporte    
    case 'POST':
        //Guardar reporte
        $data = json_decode(file_get_contents("php://input"), true);

        $pedido = null;
        if (!empty($data['id_pedido'])) {
            $pedido = new Pedido();
            $pedido->setIdPedido($data['id_pedido']);
        }

        $reporteObj = new Reporte(
            $data['id_reporte'] ?? null,
            $data['tipo'] ?? '',
            $data['fecha'] ?? '',
            $pedido
        );

        if (!empty($data['id_reporte'])){
            $exito = $reporteModel->actualizar($reporteObj);
        } else {
            $exito = $reporte->guardar($reporteObj);
        }

        echo json_encode(['success' => $exito]);
        break;

    case 'DELETE':
        //Eliminar reporte
        $id = $_GET['id_reporte'] ?? null;
        if ($id) {
            $exito = $reporteModel->eliminar($id);
            echo json_encode(['success' => $exito]);
        }
        break;
}

?>