<?php

include_once 'Persona.php';
class Pasajero extends Persona{
    
    private $documento;
    private $telefono;
    private $idviaje;

    public function __construct($documento , $nombre , $apellido ,$telefono, $idviaje ){
        
        parent::__construct($nombre , $apellido);
        $this->documento=$documento;
        $this->telefono=$telefono;
        $this->idviaje=$idviaje;
 
    }

//-----------get------------------  

    public function getDocumento()
    {
        return $this->documento;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }
     
    public function getIdviaje()
    {
        return $this->idviaje;
    }

//------------set---------------------------

    public function setDocumento($documento)
    {
        $this->documento = $documento;    
    }

    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }
    
    public function setIdviaje($idviaje)
    {
        $this->idviaje = $idviaje;
    }


//-----------tostring-------------------------

    public function __toString(){
        return parent::__toString(). "\ndocumento: " .$this->getDocumento() ."\ntelefono: " .$this->getTelefono()."\nid viaje: " .$this->getIdviaje();
    }
    
}





?>