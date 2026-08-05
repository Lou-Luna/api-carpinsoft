<?php

/*
|
| Clase reporte
|
| Esta clase contiene los atributos del reporte
| 
|
*/

class Reporte{
    private $idReporte;
    private $tipo;
    private $fecha;

    private ?Pedido $pedido;

     //Constructor
    public function __construct($idReporte = null, $tipo = null, $fecha = null, ?Pedido $pedido = null) {
        $this->idReportel = $idReporte;
        $this->tipo = $tipo;
        $this->fecha = $fecha;
        $this->pedido = $pedido;
    }

    public function getIdReporte(){
        return $this->idReporte;
    }

    public function setIdReporte($idReporte){
        $this->idReporte = $idReporte;
    }

    public function getTipo(){
        return $this->tipo;
    }

    public function setTipo($tipo){
        $this->tipo = $tipo;
    }

    public function getFecha(){
        return $this->fecha;
    }

    public function setFecha(){
        $this->fecha = $fecha;
    }

    public function getPedido(){
        return $this->pedido;
    }

    public function setPedido(Pedido $pedido){
        $this->pedido = $pedido;
    }

    // Método opcional para imprimir el objeto como texto
    public function __toString() {
        $pedidoStr = $this->pedido ? $this->ppedido->__toString() : "Sin pedido";
        return "Reporte [ID: {$this->idReporte}, Tipo: {$this->tipo}, Fecha: {$this->fecha}, Pedido: {$pedidoStr}]";
    }

}

?>