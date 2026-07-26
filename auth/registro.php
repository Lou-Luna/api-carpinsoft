<?php

/*
|
| Servicio Web - Registro de Usuario
|
| Recibe una solicitud HTTP POST con los datos del usuario,
| registra la información y devuelve una respuesta en formato JSON.
|
*/

//La respuesta vendrá en formato JSON
header("Content-Type: application/json");

//Incluir los archivos necesarios
require_once("../config/conexion.php");
require_once("../models/Usuario.php");

//Leer los datos enviados en formato JSON
$datos = json_decode(file_get_contents("php://input"), true);

//Verificar que los datos fueron recibidos
if (!$datos) {

    echo json_encode([
        "estado" => false,
        "mensaje" => "No se recibieron datos."
    ]);

    exit;
}

//Crear el objeto Usuario
$usuarioModel = new Usuario($conn);

//Registrar el usuario
$respuesta = $usuarioModel->registrar(
    $datos["nombres"],
    $datos["apellidos"],
    $datos["usuario"],
    $datos["password"],
    "Administrador"
);

//Devolver la respuesta
echo json_encode($respuesta);

?>