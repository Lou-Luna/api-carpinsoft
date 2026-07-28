<?php

/*
|
| Clase Respuesta
|
| Esta clase se encarga de enviar respuestas en formato JSON.
|
*/

class Respuesta
{
    /**
     * Envía una respuesta en formato JSON.
     *
     * @param bool $estado
     * @param string $mensaje
     * @param array|null $datos
     */
    public static function enviar($estado, $mensaje, $datos = null)
    {
        $respuesta = [
            "estado" => $estado,
            "mensaje" => $mensaje
        ];

        if ($datos !== null) {
            $respuesta["datos"] = $datos;
        }

        echo json_encode($respuesta);

        exit;
    }
}
?>