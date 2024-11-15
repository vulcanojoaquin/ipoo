<?php

class Empresa{
    private $idempresa;
    private $enombre;
    private $edireccion;

    public function __construct($idempresa = null, $enombre, $edireccion){
        $this->idempresa = $idempresa;
        $this->enombre = $enombre;
        $this->edireccion = $edireccion;
    }

    public function setIdempresa($idempresa){
		$this->idempresa=$idempresa;
	}
	public function setEnombre($enombre){
		$this->enombre=$enombre;
	}
	public function setEdireccion($edireccion){
		$this->edireccion=$edireccion;
	}
	
	
	public function getIdempresa(){
		return $this->idempresa;
	}
	public function getEnombre(){
		return $this->enombre ;
	}
	public function getEdireccion(){
		return $this->edireccion ;
	}

    public function __toString(){
        return "id empresa: " .$this->getIdempresa(). "\nnombre empresa: " .$this->getEnombre(). "\ndireccion empresa: ". $this->getEdireccion() ;
    }
    
}



?>