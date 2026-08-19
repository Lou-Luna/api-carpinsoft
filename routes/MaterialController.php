<?php

/*
|
| Controlador material
|
| Este archivo contiene todas las operaciones relacionadas con la conexión
| entre el crud y la visual.
|
*/

//Se llama a la clase
header("Content-Type: application/json; charset=UTF-8");
require_once("../config/conexion.php");
require_once("../models/Proveedor.php");
require_once("../models/Material.php");
require_once("../DAO/MaterialModel.php");

$materialModel = new MaterialModel($conexion);
$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
    case 'GET':
        //Listar materiales
        $materiales = $materialModel->listar();
        $respuesta = [];
        foreach ($materiales as $m)
        {
            $proveedorObj = $m->getProveedor();

            $respuesta[] = [
                'id_material' => $m->getIdMaterial(),
                'nombre' => $m->getNombre(),
                'cantidad' => $m->getCantidad(),
                'id_proveedor' => $proveedorObj ? $proveedorObj->getIdProveedor() : null,
                'nombre_proveedor' => $proveedorObj ? $proveedorObj->getNombre() : null
            ];
        }
        echo json_encode($respuesta);
        break;

    //Guardar o actualizar material    
    case 'POST':
        //Guardar material
        $data = json_decode(file_get_contents("php://input"), true);

        $proveedor = null;
        if (!empty($data['id_proveedor'])) {
            $proveedor = new Proveedor();
            $proveedor->setIdProveedor($data['id_proveedor']);
        }

        $material = new Material(
            $data['id_material'] ?? null,
            $data['nombre'] ?? '',
            $data['cantidad'] ?? 0,
            $proveedor
        );

        if (!empty($data['id_material'])){
            $exito = $materialModel->actualizar($material);
        } else {
            $exito = $materialModel->guardar($material);
        }

        echo json_encode(['success' => $exito]);
        break;

    case 'DELETE':
        //Eliminar material
        $id = $_GET['id_material'] ?? null;
        if ($id) {
            $exito = $materialModel->eliminar($id);
            echo json_encode(['success' => $exito]);
        }
        break;
}

?>
