<?php
include_once 'BaseDatos.php';
include_once 'Persona.php';
class ResponsableV extends Persona {
    private $numEmpleado;
    private $numLicencia;
    private $mensajeOperacion;

    public function __construct() {
        parent::__construct();
        $this->numEmpleado = null;
        $this->numLicencia = "";
    }
    public function cargar($nombre, $apellido) {
        parent::cargar($nombre, $apellido);
    }

    public function cargarConLicencia($numLicencia, $nombre, $apellido) {
        $this->cargar($nombre, $apellido); // Llama al cargar de Persona
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


    public function AgregarResponsable(){
        echo "ingresar nombre: ";
        $nombreR =trim(fgets(STDIN));
        echo "ingresar apellido: ";
        $apellidoR =trim(fgets(STDIN));
        echo "ingresar numero de licencia: ";
        $numeroLicencia =trim(fgets(STDIN));
        $this->cargarConLicencia($numeroLicencia, $apellidoR, $nombreR);
        return $this->insertar(); 
    }

    public function ModificarResponsable(){
        echo "ingresar el numero de empleado: ";
        $this->setNumEmpleado(trim(fgets(STDIN)));
        return $this->modificar(); 
    }

    public function eliminarResponsable(){
        echo "ingresar numero de empleado: ";
        $this->setNumEmpleado(trim(fgets(STDIN)));
        return $this->eliminar();
    }

    
    public function insertar() {
        $db = new BaseDatos();
        $resp = false;
        if ($db->Iniciar()) {
            $sql = "INSERT INTO responsable (rnumerolicencia , rnombre , rapellido) 
                    VALUES (".$this->getNumLicencia().",'".$this->getNombre()."','".$this->getApellido()."')";
            if ($db->Ejecutar($sql)) {
                $resp=true;
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
        $condicion="SELECT * FROM responsable WHERE rnumeroempleado = ".$this->getNumEmpleado()."";
        if ($db->Iniciar()) {
            
            if ($db->ejecutar($condicion)) {
                echo "modificar nombre: ";
                $nombreR =trim(fgets(STDIN));
                echo "modificar apellido: ";
                $apellidoR =trim(fgets(STDIN));
                echo "modificar numero de licencia: ";
                $numeroLicencia =trim(fgets(STDIN));
                $this->cargarConLicencia($numeroLicencia, $apellidoR, $nombreR);
                $sql = "UPDATE responsable SET rnumerolicencia = '".$this->getNumLicencia()."', rnombre = '".$this->getNombre()."', rapellido = '".$this->getApellido()."' WHERE rnumeroempleado = ".$this->getNumEmpleado()."";
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
        return $resp;
    }

}
