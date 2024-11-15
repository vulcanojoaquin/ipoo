<?php

class Persona{

	private $nombre;
	private $apellido;


	public function __construct($nombre , $apellido){
		
		$this->nombre = $nombre;
		$this->apellido = $apellido;
		
	}
	
	
	public function setNombre($Nom){
		$this->nombre=$Nom;
	}
	public function setApellido($Ape){
		$this->apellido=$Ape;
	}
	
	
	public function getNombre(){
		return $this->nombre ;
	}
	public function getApellido(){
		return $this->apellido ;
	}


    public function __toString(){
        return "nombre: " . $this->getNombre() . "\napellido: " . $this->getApellido() ;  
    }


}



?>