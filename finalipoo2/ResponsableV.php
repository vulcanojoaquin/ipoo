<?php
include_once 'BaseDatos.php';
include_once 'Persona.php';

class ResponsableV extends Persona{

    private $numEmpleado;
    private $numLicencia;
    
    public function __construct($nombre , $apellido, $numEmpleado, $numLicencia){
        parent::__construct($nombre , $apellido);
        $this->numEmpleado=$numEmpleado;
        $this->numLicencia=$numLicencia; 
    }


    //------------get--------------------

        public function getNumEmpleado()
        {
            return $this->numEmpleado;
        }

        public function getNumLicencia()
        {
            return $this->numLicencia;
        }

    //----------set------------------------------

        public function setNumEmpleado($numEmpleado)
        {
            $this->numEmpleado = $numEmpleado;   
        }

        public function setNumLicencia($numLicencia)
        {
            $this->numLicencia = $numLicencia;
        }

    //---------tostring-------------------------

        public function __toString(){
            return parent::__toString(). "\nnumero de empleado: ". $this->getNumEmpleado() . "\nnumero de licencia: ". $this->getNumLicencia() ;  
        }



        




}


?>