<?php
/*
|
| Configuración de la conexión a la base de datos
|
| Este archivo establece la conexión con la base de datos MySQL.
| Será utilizado por todos los servicios de la API de CarpinSoft.
|
*/

// Datos del servidor
$host = "localhost";
$usuario = "root";
$password = "";
$baseDatos = "carpinsoft";

// Crear la conexión
$conn = new mysqli($host, $usuario, $password, $baseDatos);

// Verificar si ocurrió algún error
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Establecer la codificación UTF-8 para evitar problemas con caracteres especiales
$conn->set_charset("utf8");
?>
