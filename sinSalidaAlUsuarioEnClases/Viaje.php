<?php
include_once 'BaseDatos.php';
/*include_once 'Empresa.php';
include_once 'Persona.php';
include_once 'ResponsableV.php';*/
include_once 'Pasajero.php';
class Viaje {
    private $idViaje;
    private $destino;
    private $cantMaxPasajeros;
    private $empresa;
    private $responsable;
    private $importe;
    private $pasajeros;
    private $mensajeOperacion;

    public function __construct() {
        $this->idViaje = null;
        $this->destino = "";
        $this->cantMaxPasajeros = null;
        $this->empresa = "";
        $this->responsable = "";
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

    public function imprimirPasajeros() {
        foreach ($this->pasajeros as $pasajero) {
            echo "Documento: " . $pasajero['documento'] . "\n";
            echo "Nombre: " . $pasajero['nombre'] . "\n";
            echo "Apellido: " . $pasajero['apellido'] . "\n";
            echo "ID Viaje: " . $pasajero['idViaje'] . "\n";
            echo "----------------------\n";
        }
    }


    //setters----------------------------------------------


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

    public function insertar() {
        $resp=false;
        $db = new BaseDatos();
        if ($db->Iniciar()) {
            $sql = "INSERT INTO viaje (vdestino, vcantmaxpasajeros, idempresa, rnumeroempleado, vimporte) 
                    VALUES ('".$this->getDestino()."', ".$this->getCantMaxPasajeros().", ".$this->getEmpresa().", ".$this->getResponsable().", ".$this->getImporte().")";
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
            $condicion="SELECT * from viaje where idviaje = ".$this->getIdViaje()."";
            if ($condicion) {
                $sql = "UPDATE viaje SET vdestino = '".$this->getDestino()."', vcantmaxpasajeros = ".$this->getCantMaxPasajeros().", 
                idempresa = ".$this->getEmpresa().", rnumeroempleado = ".$this->getResponsable().", 
                vimporte = ".$this->getImporte()." WHERE idviaje = ".$this->getIdViaje()."";
                if ($db->Ejecutar($sql)) {
                    $resp=true;
                }else{
                    $this->setMensajeOperacion($db->getError());
                }
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
