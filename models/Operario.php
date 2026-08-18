<?php

/*
|
| Clase operario
|
| Esta clase contiene los atributos del operario
| 
|
*/

class Operario{

    private $idOperario;
    private $nombre;
    private $rol;

    //Constructor
    public function __construct($idOperario = null, $nombre = null, $rol = null) {
        $this->idOperario = $idOperario;
        $this->nombre = $nombre;
        $this->rol = $rol;
    }

    public function getIdOperario(){
        return $this->idOperario;
    }

    public function setIdOperario($idOperario){
        $this->idOperario = $idOperario;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

    public function getRol(){
        return $this->rol;
    }

    public function setRol($rol){
        $this->rol = $rol;
    }

    //Método opcional para imprimir el objeto como texto
    public function __toString() {
        return "Operario [ID: {$this->idOperario}, Nombre: {$this->nombre}, Rol: {$this->rol}]";
    }

}