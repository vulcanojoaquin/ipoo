<?php
include_once 'BaseDatos.php';
class Empresa {
    private $idEmpresa;
    private $eNombre;
    private $eDireccion;
    private $mensajeOperacion;

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

    //metodos para gestionar-------------------------------------------------------------------

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
        $condicion= "SELECT * from empresa where idempresa = ".$this->getIdEmpresa()."";
        if ($db->Iniciar()) {
            if ($db->Ejecutar($condicion)) {
                
                $sql = "UPDATE empresa SET enombre = '".$this->getENombre()."', edireccion = '".$this->getEDireccion()."' WHERE idempresa = ".$this->getIdEmpresa()."";
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
        $condicion= "SELECT * from empresa where idempresa = ".$this->getIdEmpresa()."";
        if ($db->Iniciar()){
            if ($db->Ejecutar($condicion)){
                $sql = "DELETE FROM empresa WHERE idempresa = ".$this->getIdEmpresa()."";
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
}
