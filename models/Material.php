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

    private Proveedor $proveedor;

     //Constructor
    public function __construct($idMaterial = null, $nombre = null, $cantidad = null, $proveedor = null) {
        $this->idMaterial = $idMaterial;
        $this->nombre = $nombre;
        $this->cantidad = $cantidad;
        $this->proveedor = $proveedor;
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

    public function getProveedor(){
        return $this->proveedor;
    }

    public function setProveedor(Proveedor $proveedor){
        $this->proveedor = $proveedor;
    }

    //Método opcional para imprimir el objeto como texto
    public function __toString() {
        return "Material [ID: {$this->idMaterial}, Nombre: {$this->nombre}, Cantidad: {$this->cantidad}, Proveedor: {$this->proveedor}]";
    }

} 