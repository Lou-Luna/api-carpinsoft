<?php

/*
|
| Controlador proveedor
|
| Este archivo contiene todas las operaciones relacionadas con la conexión
| entre el crud y la visual.
|
*/

//Se llama a la clase
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

header("Content-Type: application/json; charset=UTF-8");
require_once("../config/conexion.php");
require_once("../models/Proveedor.php");
require_once("../DAO/ProveedorModel.php");

$proveedorModel = new ProveedorModel($conexion);
$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
    case 'GET':
        //Listar proveedores
        $proveedores = $proveedorModel->listar();
        $respuesta = [];
        foreach ($proveedores as $p)
        {
            $respuesta[] = [
                'id' => $p->getIdProveedor(),
                'nombre' => $p->getNombre(),
                'contacto' => $p->getContacto()
            ];
        }
        echo json_encode($respuesta);
        break;

    case 'POST':
        //Guardar o actualizar proveedor
        $data = json_decode(file_get_contents("php://input"), true);

        if (!$data){
            echo json_encode(['success' => false, 'message' => 'Sin datos']);
            exit();
        }

        //Capturar los datos del proveedor desde la solicitud
        $id = !empty($data['id_proveedor']) ? $data['id_proveedor'] : (!empty($data['id']) ? $data['id'] : null);

        $proveedor = new Proveedor(
            $id,
            $data['nombre'] ?? '',
            $data['contacto'] ?? ''
        );

        //Si ya hay ID se actualiza, si no se guarda como nuevo proveedor
        if ($id !== null && $id !== "") {
            $exito = $proveedorModel->actualizar($proveedor);
        } else {
            $exito = $proveedorModel->guardar($proveedor);
        }

        echo json_encode(['success' => $exito]);
        break;

    case 'DELETE':
        //Eliminar proveedor
        $idProveedor = $_GET['id_proveedor'] ?? null;
        if ($idProveedor) {
            $exito = $proveedorModel->eliminar($idProveedor);
            echo json_encode(['success' => $exito]);
        }
        break;
}

?>