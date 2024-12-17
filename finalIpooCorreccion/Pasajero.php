<?php
include_once 'BaseDatos.php';
include_once 'Persona.php';

class Pasajero extends Persona{
    
    private $documento;
    private $telefono;
    private $idViaje;
    private $mensajeOperacion;

    public function __construct(){
        
        parent::__construct();
        $this->documento="";
        $this->telefono=null;
        $this->idViaje=null;
 
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
     
    public function getIdViaje()
    {
        return $this->idViaje;
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
    
    public function setIdViaje($idViaje)
    {
        $this->idViaje = $idViaje;
    }

    //mensaje operacion-----------------------------

    public function setMensajeOperacion($mensajeOperacion){
		$this->mensajeOperacion=$mensajeOperacion;
	}

    public function getMensajeOperacion(){
		return $this->mensajeOperacion ;
	}

    //--------------------------------------------

    public function cargar($nombre, $apellido) {
        parent::cargar($nombre, $apellido);
    }

    public function cargarConDocumento($documento,$nombre, $apellido, $telefono, $idViaje){
        $this->cargar($nombre, $apellido);
        $this->setDocumento($documento);        
        $this->setTelefono($telefono);        
        $this->setIdViaje($idViaje);        
    }


    //-----------tostring-------------------------

    public function __toString(){
        return parent::__toString(). "\ndocumento: " .$this->getDocumento() ."\ntelefono: " .$this->getTelefono()."\nid viaje: " .$this->getIdviaje();
    }

    //-------metodos de gestion Pasajero-------------------------


    public function agregarPasajero(){
        echo "ingresar nombre: ";
        $nombreP=trim(fgets(STDIN));
        echo "ingresar apellido: ";
        $apellidoP=trim(fgets(STDIN));
        echo "ingresar documento: ";
        $documentoP=trim(fgets(STDIN));
        echo "ingresar telefono: ";
        $telefonoP=trim(fgets(STDIN));
        echo "ingresar id viaje: ";
        $idViajeP=trim(fgets(STDIN));
        $this->cargarConDocumento($documentoP,$nombreP, $apellidoP, $telefonoP, $idViajeP);
        return $this->insertar();
    }

    public function modificarPasajero(){
        echo "ingresar documento: ";
        $this->setDocumento(trim(fgets(STDIN)));
        return $this->modificar();
    }

    public function eliminarPasajero(){
        echo "ingresar documento: ";
        $this->setDocumento(trim(fgets(STDIN)));
        return $this->eliminar();
    }

    //---------------------------------------------

    public function insertar() {
        $resp=false;
        $db = new BaseDatos();
        if ($db->Iniciar()) {
            $sql = "INSERT INTO pasajero (pdocumento, pnombre, papellido, ptelefono, idviaje) 
                    VALUES ('".$this->getDocumento()."', '".$this->getNombre()."', '".$this->getApellido()."', '".$this->getTelefono()."', ".$this->getIdViaje().")";
                    if ( $db->Ejecutar($sql)) {
                        $resp=true;
                    }else {
                        $this->setMensajeOperacion($db->getError());
                    }
        }else {
            $this->setMensajeOperacion($db->getError());
        }
        return $resp;
    }

    public function modificar() {
        $resp=false;
        $db = new BaseDatos();
        if ($db->Iniciar()) {
            $condicion="SELECT * from pasajero where pdocumento = '".$this->getDocumento()."'";
            if ($db->Ejecutar($condicion)) {
                echo "ingresar nombre: ";
                $nombreP=trim(fgets(STDIN));
                echo "ingresar apellido: ";
                $apellidoP=trim(fgets(STDIN));
                $documentoP=$this->getDocumento();
                echo "ingresar telefono: ";
                $telefonoP=trim(fgets(STDIN));
                echo "ingresar id viaje: ";
                $idViajeP=trim(fgets(STDIN));
                $this->cargarConDocumento($documentoP,$nombreP, $apellidoP, $telefonoP, $idViajeP);
                $sql = "UPDATE pasajero SET pnombre = '".$this->getNombre()."', papellido = '".$this->getApellido()."', ptelefono = '".$this->getTelefono()."' 
                WHERE pdocumento = '".$this->getDocumento()."'";
                if ($db->Ejecutar($sql)) {
                    $resp=true;
                }else {
                    $this->setMensajeOperacion($db->getError());
                }
            }else {
                $this->setMensajeOperacion($db->getError());
            }    
        }else {
            $this->setMensajeOperacion($db->getError());
        }
        return $resp;
    }

    public function eliminar() {
        $resp=false;
        $db = new BaseDatos();
        if ($db->Iniciar()) {
            $sql = "DELETE FROM pasajero WHERE pdocumento = '".$this->getDocumento()."'";
            if ($db->Ejecutar($sql)) {
                $resp=true;
            }else {
                $this->setMensajeOperacion($db->getError());
            }
        }else {
            $this->setMensajeOperacion($db->getError());
        }     
        return $resp;
    }
}