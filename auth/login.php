<?php

//respuesta en formato JSON
header("Content-Type: application/json");

//conexión a la bd
include("config/conexion.php");

//leer los datos enviados
$datos = json_decode(file_get_contents("php://input"), true);

$usuario = $datos["usuario"];
$password = $datos["password"];

//buscar usuario
$sql = "SELECT * FROM usuarios WHERE usuario='$usuario'";

$resultado = $conn->query($sql);

//verificar si existe
if($resultado->num_rows > 0){

    $fila = $resultado->fetch_assoc();

    //comparar la contraseña
    if(password_verify($password, $fila["password"])){

        echo json_encode([
            "mensaje"=>"Autenticación satisfactoria",
            "estado"=>true
        ]);

    }else{

        echo json_encode([
            "mensaje"=>"Error en la autenticación",
            "estado"=>false
        ]);

    }

}else{

    echo json_encode([
        "mensaje"=>"Error en la autenticación",
        "estado"=>false
    ]);

}

$conn->close();

?>