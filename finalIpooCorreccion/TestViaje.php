<?php
include_once 'BaseDatos.php';
include_once 'Empresa.php';
include_once 'ResponsableV.php';
include_once 'Viaje.php';
include_once 'Pasajero.php';

//desde el menu: 
//1- se crea la empresa
//2- se crea el responsable
//3- se crea el viaje
//4- se crea el pasajero

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

    // Menú General----------------------------------------------------------------
    public function menuGeneral() {
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
                    $this->menuViaje();
                    break;
                case '2':
                    $this->menuPasajero();
                    break;
                case '3':
                    $this->menuResponsable();
                    break;
                case '4':
                    $this->menuEmpresa();
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

    // Menú de Viajes---------------------------------------------------------------------
    public function menuViaje() {
        do {
            echo "\nMENU GESTIONAR VIAJES\n";
            echo "(1) Agregar viaje\n";
            echo "(2) Modificar viaje\n";
            echo "(3) Eliminar viaje\n";
            echo "(4) Ver todos los pasajeros\n";
            echo "(x) Volver al menú principal\n";
            echo "Ingrese una opción: ";
            $opcion = trim(fgets(STDIN)); // Leer la opción del usuario

            switch ($opcion) {
                case '1':
                    if ($this->viaje1->agregarViaje()) {
                        echo "el viaje se agrego con exito.";
                    }else {
                        $mensajeError=$this->viaje1->getMensajeOperacion();
                        echo $mensajeError;
                    }
                    break;
                case '2':
                    if ($this->viaje1->modificarViaje()) {
                        echo "el viaje se modifico con exito.";
                    }else {
                        $mensajeError=$this->viaje1->getMensajeOperacion();
                        echo $mensajeError;
                    }
                    
                    break;
                case '3':
                    if ($this->viaje1->eliminarViaje()) {
                        echo "el viaje se elimino con exito.";
                    }else {
                        $mensajeError=$this->viaje1->getMensajeOperacion();
                        echo $mensajeError;
                    }
                    break;
                case '4':
                    if ($this->viaje1->listarPasajeros()) {
                        print_r ($this->viaje1->$getPasajeros());
                    }else {
                        echo $this->viaje1->getMensajeOperacion();
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


    // Métodos para gestionar Responsables-------------------------------------------------------------------
    public function menuResponsable() {
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
                    if ($this->responsable1->AgregarResponsable()) {
                        echo "el responsable se agrego con exito.";
                    }else {
                        echo $this->responsable1->getMensajeOperacion();
                    }
                    break;
                case '2':
                    if ($this->responsable1->ModificarResponsable()) {
                        echo "el responsable se modifico con exito.";
                    }else {
                        echo $this->responsable1->getMensajeOperacion();
                    }
                    break;
                case '3':
                    if ($this->responsable1->eliminarResponsable()) {
                        echo "el responsable se elimino con exito.";
                    }else {
                        echo $this->responsable1->getMensajeOperacion();
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
    public function menuPasajero() {
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
                    if ($this->pasajero1->agregarPasajero()) {
                        echo "el pasajero se agrego con exito.";
                    }else {
                        echo $this->pasajero1->getMensajeOperacion();
                    }
                    break;
                case '2':
                    if ($this->pasajero1->modificarPasajero()) {
                        echo "el pasajero se modifico con exito.";
                    }else {
                        echo $this->pasajero1->getMensajeOperacion();
                    }
                    break;
                case '3':
                    if ($this->pasajero1->eliminarPasajero()) {
                        echo "el pasajero se elimino con exito.";
                    }else {
                        echo $this->pasajero1->getMensajeOperacion();
                    }
                    break;
               /* case '4':
                    $this->verPasajeros();
                    break;*/
                case 'x':
                    return;  
                default:
                    echo "Opción no válida. Por favor, ingresa una opción válida.\n";
                    break;
            }
        } while ($opcion != 'x');
    }

   // Menú de Empresas-----------------------------------------------------------------------------
public function menuEmpresa() {
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
                if ($this->empresa1->agregarEmpresa()) {
                    echo "la empresa se agrego con exito.";
                }else {
                    echo $this->empresa1->getMensajeOperacion();
                }
                break;
            case '2':
                if ($this->empresa1->modificarEmpresa()) {
                    echo "la empresa se modifico con exito.";
                }else {
                    echo $this->empresa1->getMensajeOperacion();
                }
                break;
            case '3':
                if ($this->empresa1->eliminarEmpresa()) {
                    echo "la empresa se elimino con exito.";
                }else {
                    echo $this->empresa1->getMensajeOperacion();
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

}



$test1=new TestViajes();

$test1->menuGeneral();