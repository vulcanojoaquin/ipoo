<?php
include_once 'BaseDatos.php';
include_once 'Persona.php';

class Pasajero extends Persona{
    
    private $telefono;
    private $idViaje;
    //private $mensajeOperacion;

    public function __construct(){
        
        parent::__construct();
        //$this->documento="";
        $this->telefono=null;
        $this->idViaje=null;
 
    }

    public function getTelefono()
    {
        return $this->telefono;
    }
     
    public function getIdViaje()
    {
        return $this->idViaje;
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

    public function cargar($nombre, $apellido, $documento) {
        parent::cargar($nombre, $apellido, $documento);
    }

    public function cargarConDocumento($documento, $nombre, $apellido, $telefono, $idViaje){
        $this->cargar($nombre, $apellido, $documento);   
        $this->setTelefono($telefono);        
        $this->setIdViaje($idViaje);        
    }


    //-----------tostring-------------------------

    public function __toString(){
        return parent::__toString(). "\ntelefono: " .$this->getTelefono()."\nid viaje: " .$this->getIdviaje();
    }

    //-------metodos de gestion Pasajero-------------------------


    public function agregarPasajero($documentoP,$nombreP, $apellidoP, $telefonoP, $idViajeP){
        $this->cargarConDocumento($documentoP,$nombreP, $apellidoP, $telefonoP, $idViajeP);
        return $this->insertar();
    }

    public function modificarPasajero($documentoP,$nombreP, $apellidoP, $telefonoP, $idViajeP){
        $this->cargarConDocumento($documentoP,$nombreP, $apellidoP, $telefonoP, $idViajeP);
        return $this->modificar();
    }

    public function eliminarPasajero($documentoP){
        $this->Buscar($documentoP);
        return $this->eliminar();
    }

    //-----------agregar las funciones clase padre----------------------------------
    public function Buscar($dni){
		$base=new BaseDatos();
		$consulta="Select * from pasajero where pdocumento=".$dni;
		$resp= false;
		if($base->Iniciar()){
		    if($base->Ejecutar($consulta)){
				if($row2=$base->Registro()){	
				    parent::Buscar($dni);
				    $this->setTelefono($row2['ptelefono']);
				    $this->setIdViaje($row2['idviaje']);
					$resp= true;
				}				
			
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 	
		 }		
		 return $resp;
	}	
    

	public static function listar($condicion=""){
	    $arreglo = null;
		$base=new BaseDatos();
		$consulta="Select * from pasajero ";
		if ($condicion!=""){
		    $consulta=$consulta.' where '.$condicion;
		}
		$consulta.=" order by papellido ";
		//echo $consultaPersonas;
		if($base->Iniciar()){
		    if($base->Ejecutar($consulta)){				
			    $arreglo= array();
				while($row2=$base->Registro()){
					$obj=new Pasajero();
					$obj->Buscar($row2['pdocumento']);
					array_push($arreglo,$obj);
				}
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 }	
		 return $arreglo;
	}
    //------------------------------------------------------------------------------
    public function insertar() {
        $resp=false;
        $db = new BaseDatos();
        if (parent::insertar()) {
            $sql = "INSERT INTO pasajero (pdocumento, pnombre, papellido, ptelefono, idviaje) 
                    VALUES ('".$this->getDocumento()."', '".$this->getNombre()."', '".$this->getApellido()."', '".$this->getTelefono()."', ".$this->getIdViaje().")";      
            if ($db->Iniciar()) {               
                if ( $db->Ejecutar($sql)) {
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

    public function modificar() {
        $resp=false;
        $db = new BaseDatos();
        if (parent::modificar()) {
            $sql = "UPDATE pasajero SET pnombre = '".$this->getNombre()."', papellido = '".$this->getApellido()."', ptelefono = '".$this->getTelefono()."' 
            WHERE pdocumento = '".$this->getDocumento()."'";
            if ($db->Iniciar()) {               
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
        if (parent::eliminar()) {
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
        }
            
        return $resp;
    }
}