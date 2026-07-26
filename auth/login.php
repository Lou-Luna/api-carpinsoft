<?php

/*
|
| Servicio Web - Inicio de Sesión
|
| Recibe el usuario y la contraseña en formato JSON,
| valida las credenciales y devuelve una respuesta.
|
*/

//Respuesta en formato JSON
header("Content-Type: application/json");

//Incluir archivos necesarios
require_once("../config/conexion.php");
require_once("../models/Usuario.php");

//Leer datos enviados
$datos = json_decode(file_get_contents("php://input"), true);

//Verificar que los datos fueron recibieron
if (!$datos) {

    echo json_encode([
        "estado" => false,
        "mensaje" => "No se recibieron datos."
    ]);

    exit;
}

//Crear el modelo Usuario
$usuarioModel = new Usuario($conn);

//Validar las credenciales
$respuesta = $usuarioModel->iniciarSesion(
    $datos["usuario"],
    $datos["password"]
);

//Devolver respuesta
echo json_encode($respuesta);

?>