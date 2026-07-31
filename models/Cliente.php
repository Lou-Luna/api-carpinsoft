<?php

class Cliente{

private $idCliente;
private $nombre;
private $contacto;
private $direccion;

public function getIdCliente(){
    return $this->getIdCliente;
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

public function getContacto()
{
    return $this->getContacto;
}

public function setContacto($contacto){
    $this->contacto = $contacto;
}

public function getDireccion(){
    return $this->getDireccion;
}

public function setDireccion($direccion){
    $this->direccion = $direccion;
}
}