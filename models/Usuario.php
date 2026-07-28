<?php

/*
|
| Modelo Usuario
|
| Esta clase contiene todas las operaciones relacionadas con la tabla
| usuario de la base de datos.
|
*/

class Usuario
{
    private $conexion;
    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }


/**
 * Buscar un ususario por su nombre de ususario.
 * 
 * @param string $usuario
 * @return array|null
 */

public function buscarPorUsuario($usuario)
{
    //Consulta SQL
    $sql = "SELECT * FROM usuario WHERE usuario = ?";

    //Preparar la consulta
    $stmt = $this->conexion->prepare($sql);

    //Asociar el parametro que se recibe
    $stmt->bind_param("s", $usuario);

    //Ejecutar la consulta
    $stmt->execute();

    //Obtener el resultado
    $resultado = $stmt->get_result();

    //Verificar si encontró un usuario
    if ($resultado->num_rows > 0){
        return $resultado->fetch_assoc();
    }

    //Si no se encontró nada
    return null;
}

/**
 * Registrar un nuevo usuario.
 *
 * @param string $nombres
 * @param string $apellidos
 * @param string $usuario
 * @param string $password
 * @param string $rol
 * @return array
 */

public function registrar($nombres, $apellidos, $usuario, $password, $rol)
{
    //Verificar si el usuario ya existe
    if ($this->buscarPorUsuario($usuario)){
        return[
            "estado" => false,
            "mensaje" => "El nombre de usuario ya existe."
        ];
    }

    //Cifrar la contraseña
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    //Consulta SQL
    $sql = "INSERT INTO usuario (nombres, apellidos, usuario, password, rol) VALUES (?, ?, ?, ?, ?)";

    //Preparar la consulta 
    $stmt = $this->conexion->prepare($sql);

    //Asociar los parametros
    $stmt->bind_param("sssss", $nombres, $apellidos, $usuario, $passwordHash, $rol);

    //Ejecutar
    if ($stmt->execute()){
        return[
            "estado" => true,
            "mensaje" => "Usuario registrado correctamente."
        ];
    }

    return[
        "estado" => false,
        "mensaje" => "No fue posible registrar el usuario."
    ];
}

/**
 * Verificar las credenciales de un usuario.
 *
 * @param string $usuario
 * @param string $password
 * @return array
 */

public function iniciarSesion($usuario, $password)
{
    //Buscar el usuario
    $datosUsuario = $this->buscarPorUsuario($usuario);

    // Verificar si existe
    if (!$datosUsuario) {
        return [
            "estado" => false,
            "mensaje" => "Usuario o contraseña incorrectos."
        ];
    }

    //Comparar la contraseña ingresada con la guardada
    if (password_verify($password, $datosUsuario["password"])) {

        return [
            "estado" => true,
            "mensaje" => "Autenticación satisfactoria.",
            "usuario" => [
                "id" => $datosUsuario["id_usuario"],
                "nombres" => $datosUsuario["nombres"],
                "apellidos" => $datosUsuario["apellidos"],
                "usuario" => $datosUsuario["usuario"],
                "rol" => $datosUsuario["rol"]
            ]
        ];
    }

    return [
        "estado" => false,
        "mensaje" => "Usuario o contraseña incorrectos."
    ];
}

}

?>