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
require_once("../utils/Respuesta.php");

//Leer los datos enviados en formato JSON
$datos = json_decode(file_get_contents("php://input"), true);

//Verificar que los datos fueron recibidos
if (
    empty($datos["nombres"]) || empty($datos["apellidos"]) || empty($datos["usuario"]) || empty($datos["password"]))
    {
    Respuesta::enviar(false, "Todos los campos son obligatorios.");
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
Respuesta::enviar($respuesta["estado"], $respuesta["mensaje"]
);

?>