<?php

/*
|
| Clase proveedor
|
| Esta clase contiene los atributos del proveedor
| 
|
*/

class Proveedor {

    private $idPoveedor;
    private $nombre;
    private $contacto;

    //Constructor
    public function __construct($idPoveedor = null, $nombre = null, $contacto = null) {
        $this->idProveedor = $idPoveedor;
        $this->nombre = $nombre;
        $this->contacto = $contacto;
    }    

    public function getIdProveedor(){
        return $this->idProveedor;
    }

    public function setIdProveedor($idPoveedor){
        $this->idProveedor = $idPoveedor;
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

    //Método opcional para imprimir el objeto como texto
    public function __toString() {
        return "Proveedor [ID: {$this->idProveedor}, Nombre: {$this->nombre}, Contacto: {$this->contacto}]";
    }
}
    
?>
