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

        $proveedor = new Proveedor(
            $data['id_proveedor'] ?? null,
            $data['nombre'] ?? '',
            $data['contacto'] ?? ''
        );

        if (!empty($data['id_proveedor'])){
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