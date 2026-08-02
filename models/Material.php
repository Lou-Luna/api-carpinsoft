<?php

/*
|
| Clase material
|
| Esta clase contiene los atributos del material
| 
|
*/

class Material{
    private $idMaterial;
    private $nombre;
    private $cantidad;
    private $idProveedor;

     //Constructor
    public function __construct($idMaterial = null, $nombre = null, $cantidad = null, $idProveedor = null) {
        $this->idMaterial = $idMaterial;
        $this->nombre = $nombre;
        $this->cantidad = $cantidad;
        $this->idProveedor = $idProveedor;
    }

    public function getIdMaterial(){
        return $this->idMaterial;
    }

    public function setIdMaterial($idMaterial){
        $this->idMaterial = $idMaterial;
    }

    public function getNombre(){
        retunr $this->nombre;
    }

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

    public function getCantidad(){
        return $this->cantidad;
    }

    public function setCantidad($cantidad){
        $this->cantiad = $cantidad;
    }

    public function getIdProveedor(){
        return $this->IdProveedor;
    }

    public function setIdProveedor(getIdProveedor){
        $this->idProveedor = $idProveedor;
    }

    //Método opcional para imprimir el objeto como texto
    public function __toString() {
        return "Material [ID: {$this->idMaterial}, Nombre: {$this->nombre}, Cantidad: {$this->cantidad}, Proveedor: {$this->idProveedor}]";
    }

} 