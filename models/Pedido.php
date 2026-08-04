<?php

/*
|
| Clase pedido
|
| Esta clase contiene los atributos del pedido
| 
|
*/

class Pedido{

    private $idPedido;
    private $fecha;
    private $estado;
    private $especificacion;

    private ?Cliente $cliente;

    //Constructor
    public function __construct($idPedido = null, $fecha = null, $estado = null, $especificacion = null, ?Cliente $cliente = null) {
        $this->idPedido = $idPedido;
        $this->fecha = $fecha;
        $this->estado = $estado;
        $this->especificacion = $especificacion;
        $this->cliente = $cliente;
    }

    public function getIdPedido(){
        return $this->IdPedido;
    }

    public function setIdPedido($idPedido){
        $this->idPedido = $idPedido;
    }

    public function getFecha(){
        return $this->fecha;
    }

    public function setFecha($fecha){
        $this->fecha = $fecha;
    }

    public function getEstado(){
        return $this->estado;
    }

    public function setEstado($estado){
        $this->estado = $estado;
    }

    public function getEspecificacion(){
        return $this->especificacion;
    }

    public function setEspecificacion($especificacion){
        $this->especificacion = $especificacion;
    }

    public function getCliente(){
        return $this->cliente;
    }

    public function setCliente(Cliente $cliente){
        $this->cliente = $cliente;
    }

    //Método opcional para imprimir el objeto como texto
    public function __toString() {
        $clienteSrt = $this->cliente ? $this->cliente->__toString() : "Sin cliente";
        return "Pedido [ID: {$this->idPedido}, Fecha: {$this->fecha}, Estado: {$this->estado}, Especificación: {$this->especificacion}, Cliente: {$clienteSrt}]";
    }
}
?>