<?php
include_once 'BaseDatos.php';
class Empresa {
    private $idEmpresa;
    private $eNombre;
    private $eDireccion;
    //private $mensajeOperacion;

    public function __construct() {
        $this->idEmpresa = null;
        $this->eNombre = "";
        $this->eDireccion = "";
    }

    public function cargar($eNombre, $eDireccion){
       // $this->setIdEmpresa($idEmpresa);
        $this->setENombre($eNombre);
        $this->setEDireccion($eDireccion);
    }

    public function setIdEmpresa($idEmpresa) {
        $this->idEmpresa = $idEmpresa;
    }

    public function setENombre($eNombre) {
        $this->eNombre = $eNombre;
    }

    public function setEDireccion($eDireccion) {
        $this->eDireccion = $eDireccion;
    }

    public function getIdEmpresa() {
        return $this->idEmpresa;
    }

    public function getENombre() {
        return $this->eNombre;
    }

    public function getEDireccion() {
        return $this->eDireccion;
    }

    //mensaje operacion-----------------------------

    public function setMensajeOperacion($mensajeOperacion){
		$this->mensajeOperacion=$mensajeOperacion;
	}

    public function getMensajeOperacion(){
		return $this->mensajeOperacion ;
	}

    //toString-----------------------------

    public function __toString() {
        return "ID Empresa: " . $this->getIdEmpresa() . "\nNombre Empresa: " . $this->getENombre() . "\nDirección Empresa: " . $this->getEDireccion();
    }

    //metodos para gestionar----------------

    public function Buscar($idE){
		$base=new BaseDatos();
		$consultaEmpresa="Select * from empresa where idempresa=".$idE;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaEmpresa)){
				if($row2=$base->Registro()){					
				    $this->setIdEmpresa($idE);
					$this->setENombre($row2['enombre']);
					$this->setEDireccion($row2['edireccion']);
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
	    $arregloEmpresa = null;
		$base=new BaseDatos();
		$consultaEmpresas="Select * from empresa ";
		if ($condicion!=""){
		    $consultaEmpresas=$consultaEmpresas.' where '.$condicion;
		}
		$consultaEmpresas.=" order by enombre ";
		//echo $consultaEmpresas;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaEmpresas)){				
				$arregloEmpresa= array();
				while($row2=$base->Registro()){					
					$idE=$row2['idempresa'];
					$Enombre=$row2['enombre'];
					$eDirec=$row2['edireccion'];
				
					$empre=new Empresa();
					$empre->Buscar($row2['idempresa']);
					array_push($arregloEmpresa,$empre);	
				}
		 	}else{
				$this->setmensajeoperacion($base->getError());		 		
			}
		}else{
		 	$this->setmensajeoperacion($base->getError());
		 	
		}	
		 return $arregloEmpresa;
	}	


    public function insertar() {
        $resp=false;
        $db = new BaseDatos();
        if ($db->Iniciar()) {
            $sql = "INSERT INTO empresa (enombre, edireccion) VALUES ('".$this->getENombre()."', '".$this->getEDireccion()."')";
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

    public function modificar() {
        $resp=false;
        $db = new BaseDatos();
        if ($db->Iniciar()) {           
            $sql = "UPDATE empresa SET enombre = '".$this->getENombre()."', edireccion = '".$this->getEDireccion()."' WHERE idempresa = ".$this->getIdEmpresa()."";
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

    public function eliminar() {
        $resp=false;
        $db = new BaseDatos();
        if ($db->Iniciar()){
            $sql = "DELETE FROM empresa WHERE idempresa = ".$this->getIdEmpresa()."";
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
