<?php
include_once 'BaseDatos.php';
include_once 'Persona.php';
class ResponsableV extends Persona {
    private $numEmpleado;
    private $numLicencia;
    //private $mensajeOperacion;

    public function __construct() {
        parent::__construct();
        $this->numEmpleado = null;
        $this->numLicencia = "";
    }
    public function cargar($nombre, $apellido, $doc) {
        parent::cargar($nombre, $apellido, $doc);
    }

    public function cargarConLicencia($numLicencia, $nombre, $apellido, $doc) {
        $this->cargar($nombre, $apellido, $doc); // Llama al cargar de Persona
        $this->numLicencia = $numLicencia; // Setea el número de licencia
    }

    public function getNumEmpleado() {
        return $this->numEmpleado;
    }

    public function getNumLicencia() {
        return $this->numLicencia;
    }

    public function setNumEmpleado($numEmpleado) {
        $this->numEmpleado = $numEmpleado;
    }

    public function setNumLicencia($numLicencia) {
        $this->numLicencia = $numLicencia;
    }

    //mensaje operacion-----------------------------

    public function setMensajeOperacion($mensajeOperacion){
		$this->mensajeOperacion=$mensajeOperacion;
	}

    public function getMensajeOperacion(){
		return $this->mensajeOperacion ;
	}

    //toString-------------------------------------

    public function __toString() {
        return parent::__toString() . "\nNúmero de Empleado: " . $this->getNumEmpleado() . "\nNúmero de Licencia: " . $this->getNumLicencia();
    }

    
    // -----------Métodos para gestionar------------------------


    public function AgregarResponsable($nombreR, $apellidoR, $docR, $numeroLicencia){
        $this->cargarConLicencia($numeroLicencia, $nombreR, $apellidoR, $docR);
        return $this->insertar(); 
    }

    public function ModificarResponsable($numEmpleado, $numeroLicencia, $apellidoR, $nombreR, $docR=""){
        $this->Buscar($numEmpleado);
        $this->setNumEmpleado($numEmpleado);
        $this->cargarConLicencia($numeroLicencia, $apellidoR, $nombreR, $this->getDocumento());
        return $this->modificar(); 
    }

    public function eliminarResponsable($numEmpleado){
        $this->Buscar($numEmpleado);
        return $this->eliminar();
    }


   public function Buscar($numE){
        $base=new BaseDatos();
        $consulta="Select * from responsable where rnumeroempleado=".$numE;
        $resp= false;
        if($base->Iniciar()){
            if($base->Ejecutar($consulta)){
                if($row2=$base->Registro()){					
                    parent::Buscar($row2['rdocumento']);
                    $this->setNumEmpleado($row2['rnumeroempleado']);
                    $this->setNumLicencia($row2['rnumerolicencia']);
                    $resp= true;
                }				        
            }else{
                $this->setmensajeoperacion($base->getError());
                }
        }else{
            $this->setmensajeoperacion($base->getError());
            }		
        return $resp;
	}


    public static function listar($condicion=""){
	    $arreglo = null;
		$base=new BaseDatos();
		$consulta="Select * from responsable ";
		if ($condicion!=""){
		    $consulta=$consulta.' where '.$condicion;
		}
		$consulta.=" order by rnumeroempleado ";
		//echo $consultaPersonas;
		if($base->Iniciar()){
		    if($base->Ejecutar($consulta)){				
			    $arreglo= array();
				while($row2=$base->Registro()){
					$obj=new ResposableV();
					$obj->Buscar($row2['rnumeroempleado']);
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


    public function insertar() {
        $db = new BaseDatos();
        $resp = false;
        if (parent::insertar()) {
            $sql = "INSERT INTO responsable (rnumerolicencia ,rdocumento, rnombre , rapellido) 
                    VALUES (".$this->getNumLicencia().",'".$this->getDocumento()."','".$this->getNombre()."','".$this->getApellido()."')";
            if ($db->Iniciar()) {               
                if ($db->Ejecutar($sql)) {
                    $resp=true;
                }else {
                    $this->setmensajeOperacion($db->getError());
                }
            }else {
                $this->setmensajeOperacion($db->getError());
            }
        }else {
            $this->setmensajeOperacion($db->getError());
        }
        return $resp;        
    }

   

    public function modificar() {
        $resp = false;
        $db = new BaseDatos();
        if (parent::modificar()) {
            $sql = "UPDATE responsable SET rnumerolicencia = '".$this->getNumLicencia()."', rnombre = '".$this->getNombre()."', rapellido = '".$this->getApellido()."' WHERE rnumeroempleado = ".$this->getNumEmpleado()."";      
            if ($db->Iniciar()) {  
                 if ($db->ejecutar($sql)) {
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
                $sql = "DELETE FROM responsable WHERE rnumeroempleado = ".$this->getNumEmpleado()."";
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
