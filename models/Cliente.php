<?php

/*
|
| Clase cliente
|
| Esta clase contiene los atributos del cliente
| 
|
*/

class Cliente {

    private $idCliente;
    private $nombre;
    private $contacto;
    private $direccion;

    //Constructor
    public function __construct($idCliente = null, $nombre = null, $contacto = null, $direccion = null) {
        $this->idCliente = $idCliente;
        $this->nombre = $nombre;
        $this->contacto = $contacto;
        $this->direccion = $direccion;
    }

    public function getIdCliente(){
        return $this->idCliente;
    }

    public function setIdCliente($idCliente){
        $this->idCliente = $idCliente;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

    public function getContacto(){
        return $this->contacto;
    }

    public function setContacto($contacto){
        $this->contacto = $contacto;
    }

    public function getDireccion(){
        return $this->direccion;
    }

    public function setDireccion($direccion){
        $this->direccion = $direccion;
    }

    //Método opcional para imprimir el objeto como texto
    public function __toString() {
        return "Cliente [ID: {$this->idCliente}, Nombre: {$this->nombre}, Contacto: {$this->contacto}, Dirección: {$this->direccion}]";
    }
}
?>
