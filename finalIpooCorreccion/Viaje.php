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

    //mensaje operacion-----------------------------

    public function setMensajeOperacion($mensajeOperacion){
		$this->mensajeOperacion=$mensajeOperacion;
	}

    public function getMensajeOperacion(){
		return $this->mensajeOperacion ;
	}


    //------------metodos para gestion--------------------------------------------------------------

    public function agregarViaje(){
        echo "ingresar destino: ";
        $destinoV=trim(fgets(STDIN));
        echo "ingresar cant max pasajeros: ";
        $cantMax=trim(fgets(STDIN));
        echo "ingresar idEmpresa responsable: ";
        $idEmpresa=trim(fgets(STDIN));
        echo "ingresar numero empleado responsable: ";
        $numResponsable=trim(fgets(STDIN));
        echo "ingresar importe";
        $importeV=trim(fgets(STDIN));
        $this->cargar($destinoV ,$cantMax, $idEmpresa, $numResponsable, $importeV);
        return $this->insertar();
    }

    public function modificarViaje(){
        echo "ingresar idViaje: ";
        $this->setIdViaje(trim(fgets(STDIN)));
        return $this->modificar();
    }

    public function eliminarViaje(){
        echo "ingresar idViaje: ";
        $this->setIdViaje(trim(fgets(STDIN)));
        return $this->eliminar();
    }

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
                echo "ingresar destino: ";
                $destinoV=trim(fgets(STDIN));
                echo "ingresar cant max pasajeros: ";
                $cantMax=trim(fgets(STDIN));
                echo "ingresar idEmpresa responsable: ";
                $idEmpresa=trim(fgets(STDIN));
                echo "ingresar numero empleado responsable: ";
                $numResponsable=trim(fgets(STDIN));
                echo "ingresar importe";
                $importeV=trim(fgets(STDIN));
                $this->cargar($destinoV ,$cantMax, $idEmpresa, $numResponsable, $importeV);
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

    public function listarPasajeros(){
        echo "ingresar id del viaje: ";
        $this->setIdViaje(trim(fgets(STDIN)));
        return $this->pasajerosViaje();
    }

    public function pasajerosViaje(){
        $resp=false;
        $db=new BaseDatos();
        if ($db->Iniciar()) {
            $condicion="SELECT * from pasajero where idviaje = ".$this->getIdViaje()."";
            if ($db->Ejecutar($condicion)) {
                //aqui quiero la logica
                while ($fila = $db->Registro()) {
                    $pasajero = new Pasajero(
                        $fila['pdocumento'],
                        $fila['pnombre'],
                        $fila['papellido'],
                        $fila['ptelefono'],
                        $this->getIdViaje()
                    );
                    $this->setPasajeros($pasajero);
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
