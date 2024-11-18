<?php

class Persona{

	private $nombre;
	private $apellido;



	public function __construct(){
		
		$this->nombre = "";
		$this->apellido = "";
		
	}
	
	
	public function setNombre($nombre){
		$this->nombre=$nombre;
	}
	public function setApellido($apellido){
		$this->apellido=$apellido;
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

	public function cargar($Nom,$Ape){		
		$this->setNombre($Nom);
		$this->setApellido($Ape);
    }

	


}



?>