<?php
include_once 'BaseDatos.php';
include_once 'Empresa.php';
/*include_once 'Persona.php';*/
include_once 'ResponsableV.php';
include_once 'Pasajero.php';
class Viaje {
    private $idViaje;
    private $destino;
    private $cantMaxPasajeros;
    private $empresa;
    private $responsable;//referencia obj
    private $importe;
    private $pasajeros;//array de objetos
    private $mensajeOperacion;


    public function __construct() {
        $this->idViaje = null;
        $this->destino = "";
        $this->cantMaxPasajeros = null;
        $this->empresa = new Empresa();
        $this->responsable = new ResponsableV();
        $this->importe = null;
        $this->pasajeros= [];
    }
    public function cargar($destino ,$cantMaxPasajeros, $empresa, $responsable, $importe){
        $this->setDestino($destino);
        $this->setCantMaxPasajeros($cantMaxPasajeros);
        $this->setEmpresa($empresa);
        $this->setResponsable($responsable);
        $this->setImporte($importe);
    }
    

    public function getIdViaje(){
        return $this->idViaje;
    }
    public function getDestino(){
        return $this->destino;
    }
    public function getCantMaxPasajeros(){
        return $this->cantMaxPasajeros;
    }
    public function getEmpresa(){
        return $this->empresa;
    }
    public function getResponsable(){
        return $this->responsable;
    }
    public function getImporte(){
        return $this->importe;
    }
    public function getPasajeros(){
        return $this->pasajeros;
    }


//----------------------------------------------
    public function imprimirPasajeros($idV) {
        $pasajero=new Pasajero();
        if ($this->pasajeros = $pasajero->listar($idV)) {
        foreach ($this->pasajeros as $obj) {
            echo $obj."\n";
            echo "----------------------\n";
            }
        }else {
            echo "error imprimir pasajeros";
        }       
    }
//-----------------------------------------------


    public function setIdViaje($idViaje){
        $this->idViaje=$idViaje;
    }

    public function setDestino($destino){
        $this->destino=$destino;
    }

    public function setCantMaxPasajeros($cantMaxPasajeros){
        $this->cantMaxPasajeros=$cantMaxPasajeros;
    }

    public function setEmpresa($empresa){
        $this->empresa=$empresa;
    }

    public function setResponsable($responsable){
        $this->responsable=$responsable;
    }

    public function setImporte($importe){
        $this->importe=$importe;
    }

    public function setPasajeros($pasajeros){
        $this->pasajeros=$pasajeros;
    }

    public function resetearPasajeros(){
        $this->pasajeros=[];
    }

    //mensaje operacion-----------------------------

    public function setMensajeOperacion($mensajeOperacion){
		$this->mensajeOperacion=$mensajeOperacion;
	}

    public function getMensajeOperacion(){
		return $this->mensajeOperacion ;
	}


    //------------metodos para gestion--------------------------------------------------------------

    public function Buscar($idViaje){
        $base=new BaseDatos();
		$consultaPersona="Select * from viaje where idviaje=".$idViaje;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaPersona)){
				if($row2=$base->Registro()){					
				    $this->setIdViaje($idViaje);
					$this->setDestino($row2['vdestino']);
					$this->setCantMaxPasajeros($row2['vcantmaxpasajeros']);
					$this->empresa->Buscar($row2['idempresa']);
					$this->responsable->Buscar($row2['rnumeroempleado']);
					$this->setImporte($row2['vimporte']);
					$resp= true;
				}				
			
		 	}	else {
		 			$this->setMensajeOperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->setMensajeOperacion($base->getError());
		 	
		 }		
		 return $resp;
    }

    public static function listar($condicion=""){
	    $arregloViaje = null;
		$base=new BaseDatos();
		$consultaViajes="Select * from viaje ";
		if ($condicion!=""){
		    $consultaViajes=$consultaViajes.' where '.$condicion;
		}
		$consultaViajes.=" order by vdestino ";
		//echo $consultaViajes;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaViajes)){				
				$arregloViaje= array();
				while($row2=$base->Registro()){
					
                    $empresaV=new Empresa();
                    $ResponsableV=new Responsable();

                    $idV=$row2['idviaje'];
					$destinoV=$row2['vdestino'];
					$cantMaxP=$row2['cantMaxPasajeros'];
					$empresaV->Buscar($row2['idempresa']);
					$ResponsableV->Buscar($row2['rnumeroempleado']);
                    $importeV=$row2['vimporte'];				
				
					$viaje=new Viaje();
                    $viaje->setIdViaje($idV);
					$viaje->cargar($destinoV ,$cantMaxP, $empresaV, $responsableV, $importeV);
					array_push($arregloViaje,$viaje);
	
				}
				
			
		 	}	else {
		 			$this->setMensajeOperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->setMensajeOperacion($base->getError());
		 	
		 }	
		 return $arregloViaje;
	}	

    //*obj responsable/empresa-----------AGREGAR  LISTAR--------Y BUSCAR-----------------
    public function insertar() {
        $resp=false;
        $db = new BaseDatos();
        if ($db->Iniciar()) {
            $sql = "INSERT INTO viaje (vdestino, vcantmaxpasajeros, idempresa, rnumeroempleado, vimporte) 
                    VALUES ('".$this->getDestino()."', ".$this->getCantMaxPasajeros().", ".$this->empresa->getIdEmpresa().", ".$this->responsable->getNumEmpleado().", ".$this->getImporte().")";
            if ($db->Ejecutar($sql)) {
                $resp=true;
            }else {
                $this->setMensajeOperacion($db->getError());
            }        
        }else{
            $this->setMensajeOperacion($db->getError());
        }
        return $resp;
    }

    public function modificar() {
        $resp=false;
        $db = new BaseDatos();
        if ($db->Iniciar()) {
            $sql = "UPDATE viaje SET vdestino = '".$this->getDestino()."', vcantmaxpasajeros = ".$this->getCantMaxPasajeros().", 
            idempresa = ".$this->empresa->getIdEmpresa().", rnumeroempleado = ".$this->responsable->getNumEmpleado().", 
            vimporte = ".$this->getImporte()." WHERE idviaje = ".$this->getIdViaje()."";
            if ($db->Ejecutar($sql)) {
                $resp=true;
            }else{
                $this->setMensajeOperacion($db->getError());
            }
        }else{
            $this->setMensajeOperacion($db->getError());
        }
        return $resp;
    }

    public function eliminar() {
        $resp=false;
        $db = new BaseDatos();
        if ($db->Iniciar()) {
            $sql = "DELETE FROM viaje WHERE idviaje = ".$this->getIdViaje();
            if ($db->Ejecutar($sql)) {
                $resp=true;
            }else{
                $this->setMensajeOperacion($db->getError());
            }
        }else{
            $this->setMensajeOperacion($db->getError());
        }
        return $resp;
    }

}
