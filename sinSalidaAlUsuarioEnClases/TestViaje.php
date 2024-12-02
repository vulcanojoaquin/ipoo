<?php

/*-------ENUNCIADO------------------------------------------------------------------------------

Una empresa de transporte desea gestionar la información 
correspondiente a los viajes que realiza. De los pasajeros 
se conoce su nombre, apellido, NÚMERO DE DOCUMENTO y teléfono. 
El viaje ahora contiene una referencia a una colección de objetos de la clase Pasajero. 
También se desea guardar la información de la persona responsable de realizar el viaje, 
para ello cree una clase ResponsableV que registra el NÚMERO DE EMPLEADO, número de licencia, nombre y apellido.

La clase Viaje debe hacer referencia al responsable de realizar el viaje.

------------------------------------------------------------------------------------
|1. EJECUTE EL SCRIPT SQL PROVISTO PARA CREAR LA BASE DE DATOS bdviajes Y SUS TABLAS.|
------------------------------------------------------------------------------------

2. Implementar dentro de la clase TestViajes una operación que permita ingresar, modificar y eliminar la información de la empresa de viajes.

3. Implementar dentro de la clase TestViajes una operación que permita ingresar, modificar y eliminar la información de un viaje, teniendo en cuenta las particularidades expuestas en el dominio a lo largo del cuatrimestre.

------------------------------------------------------------------------------------------------------*/

include_once 'BaseDatos.php';
include_once 'Empresa.php';
include_once 'ResponsableV.php';
include_once 'Viaje.php';
include_once 'Pasajero.php';


class TestViajes {
    public $db;
    public $viaje1;
    public $empresa1;
    public $responsable1;
    public $pasajero1;

    public function __construct() {
        $this->db = new BaseDatos();
        $this->empresa1 = new Empresa();
        $this->responsable1 = new ResponsableV();
        $this->viaje1 = new Viaje();
        $this->pasajero1 = new Pasajero();
    }

//-------------------------------------------------------------------
public function agregarEmpresa($nombreE , $direccionE){
    $this->empresa1->cargar($nombreE , $direccionE);
    return $this->empresa1->insertar();
}

public function modificarEmpresa($idEmpresa, $nombreE, $direccionE){
    
    $this->empresa1->setIdEmpresa($idEmpresa);
    $this->empresa1->cargar($nombreE, $direccionE);
    return $this->empresa1->modificar();
}

public function eliminarEmpresa($idEmpresa){
    
    $this->empresa1->setIdEmpresa($idEmpresa);
    return $this->empresa1->eliminar();
}
//---------------------------------------------------------------------
public function agregarViaje($destinoV ,$cantMax, $idEmpresa, $numResponsable, $importeV){
    $this->viaje1->cargar($destinoV ,$cantMax, $idEmpresa, $numResponsable, $importeV);
    return $this->viaje1->insertar();
}

public function modificarViaje($idViaje, $destinoV ,$cantMax, $idEmpresa, $numResponsable, $importeV){
    $this->viaje1->setIdViaje($idViaje);
    $this->viaje1->cargar($destinoV ,$cantMax, $idEmpresa, $numResponsable, $importeV);
    return $this->viaje1->modificar();
}

public function eliminarViaje($idViaje){
    $this->viaje1->setIdViaje($idViaje);
    return $this->viaje1->eliminar();
}

//---------------------------------------
public function setearArrayPasajeros($idViaje){
    $this->viaje1->setIdViaje($idViaje);
    return $this->pasajerosViaje();
}

public function pasajerosViaje(){
    $resp=false;
    $pasajeros=[];
    if ($this->db->Iniciar()) {
        $condicion="SELECT * FROM pasajero WHERE idviaje = ".$this->viaje1->getIdViaje();
        if ($this->db->Ejecutar($condicion)) {
            while ($fila = $this->db->Registro()) {
                $this->pasajero1->cargarConDocumento(
                    $fila['pdocumento'],
                    $fila['pnombre'],
                    $fila['papellido'],
                    $fila['ptelefono'],
                    $this->viaje1->getIdViaje()
                );
                $pasajeros[] = [
                    'documento' => $this->pasajero1->getDocumento(),
                    'nombre' => $this->pasajero1->getNombre(),
                    'apellido' => $this->pasajero1->getApellido(),
                    'telefono' => $this->pasajero1->getTelefono(),
                    'idViaje' => $this->pasajero1->getIdViaje()
                ];
                $this->viaje1->resetearPasajeros();
                $this->viaje1->setPasajeros($pasajeros);
                $resp=true;
            }
        }else {
            $this->viaje1->setMensajeOperacion($this->db->getError());
        }
    }else {
        $this->viaje1->setMensajeOperacion($this->db->getError());
    }
    return $resp;
}






    

}


//desde el menu: 
//1- se crea la empresa
//2- se crea el responsable
//3- se crea el viaje
//4- se crea el pasajero


$test1=new TestViajes();

// Menú General----------------------------------------------------------------
    function menuGeneral() {
        do {
            echo "\nMENU GENERAL\n";
            echo "(1) GESTIONAR VIAJES\n";
            echo "(2) GESTIONAR PASAJEROS\n";
            echo "(3) GESTIONAR RESPONSABLE VIAJE\n";
            echo "(4) GESTIONAR EMPRESAS\n";
            echo "(x) SALIR\n";
            echo "Ingrese una opción: ";
            $opcion = trim(fgets(STDIN)); 

            switch ($opcion) {
                case '1':
                    menuViaje();
                    break;
                case '2':
                    menuPasajero();
                    break;
                case '3':
                    menuResponsable();
                    break;
                case '4':
                    menuEmpresa();
                    break;
                case 'x':
                    echo "Saliendo...\n";
                    break;
                default:
                    echo "Opción no válida. Por favor, ingresa una opción válida.\n";
                    break;
            }
        } while ($opcion != 'x');
    }

    // Menú de Viajes---------------TERMINAR CASE 4------------------------------------------------------
    function menuViaje() {
        $test1=new TestViajes();
        do {
            
            echo "\nMENU GESTIONAR VIAJES\n";
            echo "(1) Agregar viaje\n";
            echo "(2) Modificar viaje\n";
            echo "(3) Eliminar viaje\n";
            echo "(4) Ver todos los pasajeros\n";
            echo "(x) Volver al menú principal\n";
            echo "Ingrese una opción: ";
            $opcion = trim(fgets(STDIN));

            switch ($opcion) {
                case '1':
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
                    if ($test1->agregarViaje($destinoV ,$cantMax, $idEmpresa, $numResponsable, $importeV)) {
                    echo "el viaje se agrego con exito.";
                    }else {
                        $mensajeError=$test1->viaje1->getMensajeOperacion();
                        echo $mensajeError;
                    }
                    break;
                case '2':
                    echo "ingresar idViaje: ";
                    $idViaje=(trim(fgets(STDIN)));
                    echo "ingresar destino: ";
                    $destinoV=trim(fgets(STDIN));
                    echo "ingresar cant max pasajeros: ";
                    $cantMax=trim(fgets(STDIN));
                    echo "ingresar idEmpresa responsable: ";
                    $idEmpresa=trim(fgets(STDIN));
                    echo "ingresar numero empleado responsable: ";
                    $numResponsable=trim(fgets(STDIN));
                    echo "ingresar importe:";
                    $importeV=trim(fgets(STDIN));
                    if ($test1->modificarViaje($idViaje, $destinoV ,$cantMax, $idEmpresa, $numResponsable, $importeV)){
                        echo "el viaje se modifico con exito.";
                    }else {
                        $mensajeError=$test1->viaje1->getMensajeOperacion();
                        echo $mensajeError;
                    }
                    
                    break;
                case '3':
                    echo "ingresar idViaje: ";
                    $idViaje=trim(fgets(STDIN));
                    if ($test1->eliminarViaje($idViaje)) {
                        echo "el viaje se elimino con exito.";
                    }else {
                        $mensajeError=$test1->viaje1->getMensajeOperacion();
                        echo $mensajeError;
                    }
                    break;
                case '4':
                    echo "ingresar id del viaje: ";
                    $idViaje=(trim(fgets(STDIN)));
                    if ($test1->setearArrayPasajeros($idViaje)) {
                        $test1->viaje1->imprimirPasajeros();
                    }else {
                        echo "ERROR: ".$test1->viaje1->getMensajeOperacion();
                    }
                    
                    break;
                case 'x':
                    return;  
                default:
                    echo "Opción no válida. Por favor, ingresa una opción válida.\n";
                    break;
            }
        } while ($opcion != 'x');
    }


    // Mnu para gestionar Responsables-------------------------------------------------------------------
    function menuResponsable() {
        $test1=new TestViajes();
        do {           
            echo "\nMENU GESTIONAR RESPONSABLES\n";
            echo "(1) Agregar responsable\n";
            echo "(2) Modificar responsable\n";
            echo "(3) Eliminar responsable\n";
           
            echo "(x) Volver al menú principal\n";
            echo "Ingrese una opción: ";
            $opcion = trim(fgets(STDIN));

            switch ($opcion) {
                case '1':
                    echo "ingresar nombre: ";
                    $nombreR =trim(fgets(STDIN));
                    echo "ingresar apellido: ";
                    $apellidoR =trim(fgets(STDIN));
                    echo "ingresar numero de licencia: ";
                    $numeroLicencia =trim(fgets(STDIN));
                    if ($test1->responsable1->AgregarResponsable($nombreR, $apellidoR, $numeroLicencia)) {
                        echo "el responsable se agrego con exito.";
                    }else {
                        echo $test1->responsable1->getMensajeOperacion();
                    }
                    break;
                case '2':
                    echo "ingresar el numero de empleado: ";
                    $numEmpleado=trim(fgets(STDIN));
                    echo "modificar nombre: ";
                    $nombreR =trim(fgets(STDIN));
                    echo "modificar apellido: ";
                    $apellidoR =trim(fgets(STDIN));
                    echo "modificar numero de licencia: ";
                    $numeroLicencia =trim(fgets(STDIN));
                    if ($test1->responsable1->ModificarResponsable($numEmpleado, $numeroLicencia, $apellidoR, $nombreR)) {
                        echo "el responsable se modifico con exito.";
                    }else {
                        echo $test1->responsable1->getMensajeOperacion();
                    }
                    break;
                case '3':
                    echo "ingresar numero de empleado: ";
                    $numEmpleado=trim(fgets(STDIN));
                    if ($test1->responsable1->eliminarResponsable($numEmpleado)) {
                        echo "el responsable se elimino con exito.";
                    }else {
                        echo "ERRORR: ".$test1->responsable1->getMensajeOperacion();
                    }
                    break;
                case 'x':
                    return;  
                default:
                    echo "Opción no válida. Por favor, ingresa una opción válida.\n";
                    break;
            }
        } while ($opcion != 'x');
    }

    // Menu gestionar Pasajeros----------------------------------------------------------------------------
    function menuPasajero() {
        $test1=new TestViajes();
        do {
            echo "\nMENU GESTIONAR PASAJEROS\n";
            echo "(1) Agregar pasajero\n";
            echo "(2) Modificar pasajero\n";
            echo "(3) Eliminar pasajero\n";
            echo "(x) Volver al menú principal\n";
            echo "Ingrese una opción: ";
            $opcion = trim(fgets(STDIN));

            switch ($opcion) {
                case '1':
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
                    if ($test1->pasajero1->agregarPasajero($documentoP,$nombreP, $apellidoP, $telefonoP, $idViajeP)) {
                        echo "el pasajero se agrego con exito.";
                    }else {
                        echo $test1->pasajero1->getMensajeOperacion();
                    }
                    break;
                case '2':
                    echo "ingresar documento";
                    $documentoP=trim(fgets(STDIN));
                    echo "ingresar nombre: ";
                    $nombreP=trim(fgets(STDIN));
                    echo "ingresar apellido: ";
                    $apellidoP=trim(fgets(STDIN));                   
                    echo "ingresar telefono: ";
                    $telefonoP=trim(fgets(STDIN));
                    echo "ingresar id viaje: ";
                    $idViajeP=trim(fgets(STDIN));
                    if ($test1->pasajero1->modificarPasajero($documentoP,$nombreP, $apellidoP, $telefonoP, $idViajeP)) {
                        echo "el pasajero se modifico con exito.";
                    }else {
                        echo $test1->pasajero1->getMensajeOperacion();
                    }
                    break;
                case '3':
                    echo "ingresar documento: ";
                    $documentoP=trim(fgets(STDIN));
                    if ($test1->pasajero1->eliminarPasajero($documentoP)) {
                        echo "el pasajero se elimino con exito.";
                    }else {
                        echo $test1->pasajero1->getMensajeOperacion();
                    }
                    break;
                case 'x':
                    return;  
                default:
                    echo "Opción no válida. Por favor, ingresa una opción válida.\n";
                    break;
            }
        } while ($opcion != 'x');
    }

   // Menú de Empresas-----------------------------------------------------------------------------
function menuEmpresa() {
    $test1=new TestViajes(); 
    do {
        echo "\nMENU GESTIONAR EMPRESAS\n";
        echo "(1) Agregar empresa\n";
        echo "(2) Modificar empresa\n";
        echo "(3) Eliminar empresa\n";
        echo "(x) Volver al menú principal\n";
        echo "Ingrese una opción: ";
        $opcion = trim(fgets(STDIN));  

        switch ($opcion) {
            case '1':
                echo "nombre Empresa: ";
                $nombreE=trim(fgets(STDIN));
                echo "direccion empresa: ";
                $direccionE=trim(fgets(STDIN));
                if ($test1->agregarEmpresa($nombreE , $direccionE)) {
                    echo "la empresa se agrego con exito.";
                }else {
                    echo $test1->empresa1->getMensajeOperacion();
                }
                break;
            case '2':
                echo "ingresar id empresa: ";
                $idEmpresa=trim(fgets(STDIN));
                echo "modificar nombre empresa: ";
                $nombreE =trim(fgets(STDIN));
                echo "modificar direccion: ";
                $direccionE =trim(fgets(STDIN));
                if ($test1->modificarEmpresa($idEmpresa, $nombreE, $direccionE)) {                    
                    echo "la empresa se modifico con exito.";
                }else {
                    echo $test1->empresa1->getMensajeOperacion();
                }
                break;
            case '3':
                echo "ingresar id empresa: ";
                $idEmpresa=trim(fgets(STDIN));
                if ($test1->eliminarEmpresa($idEmpresa)) {
                    echo "la empresa se elimino con exito.";
                }else {
                    echo $test1->empresa1->getMensajeOperacion();
                }
                break;
            case 'x':
                return;  
            default:
                echo "Opción no válida. Por favor, ingresa una opción válida.\n";
                break;
        }
    } while ($opcion != 'x');
}

menuGeneral();