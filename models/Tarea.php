<?php

/*
|
| Clase tarea
|
| Esta clase contiene los atributos de la tarea
| 
|
*/

require_once("../models/Pedido.php");
require_once("..models/Operario.php");

class Tarea{

    private $idTarea;
    private $descripcion;
    private $estado;

    private ?Pedido $pedido;
    private ?Operario $operario;

    //Constructor
    public function __construct($idTarea = null, $descripcion = null, $estado = null, ?Pedido $pedido = null, ?Operario $operario = null) {
        $this->idTarea = $idTarea;
        $this->descripcion = $descripcion;
        $this->estado = $estado;
        $this->pedido = $pedido;
        $this->operario = $operario;
    }

    public function getIdTarea(){
        return $this->idTarea;
    }

    public function setIdTarea($idTarea){
        $this->idTarea = $idTarea;
    }

    public function getDescripcion(){
        return $this->descripcion;
    }

    public function setDescripcion($descripcion){
        $this->descripcion = $descripcion;
    }

    public function getEstado(){
        return $this->Estado;
    }

    public function setEstado($estado){
        $this->estado = $estado;
    }

    public function getPedido(){
        return $this->pedido;
    }

    public function setPedido(Pedido $pedido){
        $this->pedido = $pedido;
    }

    public function getOperario(){
        return $this->operario;
    }

    public function setOperario(Operario $operario){
        $this->operario = $operario;
    }

    // Método opcional para imprimir el objeto como texto
    public function __toString() {
        $pedidoStr = $this->pedido ? $this->pedido->__toString() : "Sin pedido";
        $operarioStr = $this->operario ? $this->operario->__toString() : "Sin operario";
        return "Tarea [ID: {$this->idTarea}, Descripción: {$this->descripcion}, Estado: {$this->estado}, Pedido: {$pedidoStr}, Operario: {$operarioStr}]";
    }

}

?>