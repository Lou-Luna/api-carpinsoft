<?php

/*
|
| Clase pedido-material
|
| Esta clase contiene los atributos de pedido-material
| 
|
*/

require_once("../models/Pedido.php");
require_once("..models/Material.php");

class PedidoMaterial{

    private ?Pedido $pedido;
    private ?Material $material;

    private $cantidadUsada;

    //Constructor
    public function __construct(?Pedido $pedido = null, ?Material $material = null, $cantidadUsada = null) {
        $this->pedido = $pedido;
        $this->material = $material;
        $this->cantidadUsada = $cantidadUsada;
    }

    public function getPedido(){
        return $this->pedido;
    }

    public function setPedido(Pedido $pedido){
        $this->pedido = $pedido;
    }

    public function getMaterial(){
        return $this->material;
    }

    public function setMaterial(Material $material){
        $this->material = $material;
    }

    public function getCantidadUsada(){
        return $this->cantidadUsada;
    }

    public function setCantidadUsada($cantidadUsada){
        $this->cantidadUsada = $cantidadUsada;
    }

    // Método opcional para imprimir el objeto como texto
    public function __toString() {
        $pedidoStr = $this->pedido ? $this->pedido->__toString() : "Sin pedido";
        $materialStr = $this->material ? $this->material->__toString() : "Sin material";
        return "Pedido: {$pedidoStr}, Material: {$materialStr}, Cantidad usada: {$this->cantidadUsada}]";
    }
    
}

?>