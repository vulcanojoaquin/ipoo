<?php
include_once 'BaseDatos.php';
include_once 'Empresa.php';
include_once 'Persona.php';
include_once 'ResponsableV.php';
include_once 'Viaje.php';
include_once 'Pasajero.php';

class TestViajes {
    private $db;

    public function __construct() {
        $this->db = new BaseDatos();
    }

    //-------------Métodos para gestionar empresas----------------------------------------------------------

    public function agregarEmpresa($enombre, $edireccion) {
        $this->db->Iniciar();
        $sql = "INSERT INTO empresa (enombre, edireccion) VALUES ('$enombre', '$edireccion')";
        if ($this->db->Ejecutar($sql)) {
            echo "Empresa agregada con éxito.\n";
        } else {
            echo "Error al agregar la empresa: " . $this->db->getError();
        }
    }

    public function modificarEmpresa($idempresa, $enombre, $edireccion) {
        $this->db->Iniciar();
        $sql = "UPDATE empresa SET enombre='$enombre', edireccion='$edireccion' WHERE idempresa=$idempresa";
        if ($this->db->Ejecutar($sql)) {
            echo "Empresa modificada con éxito.\n";
        } else {
            echo "Error al modificar la empresa: " . $this->db->getError();
        }
    }

    public function eliminarEmpresa($idempresa) {
        $this->db->Iniciar();
        $sql = "DELETE FROM empresa WHERE idempresa=$idempresa";
        if ($this->db->Ejecutar($sql)) {
            echo "Empresa eliminada con éxito.\n";
        } else {
            echo "Error al eliminar la empresa: " . $this->db->getError();
        }
    }

    private function existeEmpresa($idempresa) {
    $this->db->Iniciar();
    $sql = "SELECT * FROM empresa WHERE idempresa = $idempresa";
    $this->db->Ejecutar($sql);
    $resultado = $this->db->Registro();
    return $resultado != null;
}

    //------------------------Métodos para gestionar viajes--------------------------------------------------

    public function agregarViaje($destino, $cantMaxPasajeros, $idempresa, $rnumeroempleado, $importe) {
        $this->db->Iniciar();
        $sql = "INSERT INTO viaje (vdestino, vcantmaxpasajeros, idempresa, rnumeroempleado, vimporte)
                VALUES ('$destino', $cantMaxPasajeros, $idempresa, $rnumeroempleado, $importe)";
        if ($this->db->Ejecutar($sql)) {
            echo "Viaje agregado con éxito.\n";
        } else {
            echo "Error al agregar el viaje: " . $this->db->getError();
        }
    }

    public function modificarViaje($idviaje, $destino, $cantMaxPasajeros, $idempresa, $rnumeroempleado, $importe) {
        $this->db->Iniciar();
        $sql = "UPDATE viaje SET vdestino='$destino', vcantmaxpasajeros=$cantMaxPasajeros, 
                idempresa=$idempresa, rnumeroempleado=$rnumeroempleado, vimporte=$importe 
                WHERE idviaje=$idviaje";
        if ($this->db->Ejecutar($sql)) {
            echo "Viaje modificado con éxito.\n";
        } else {
            echo "Error al modificar el viaje: " . $this->db->getError();
        }
    }

    public function eliminarViaje($idviaje) {
        $this->db->Iniciar();
        $sql = "DELETE FROM viaje WHERE idviaje=$idviaje";
        if ($this->db->Ejecutar($sql)) {
            echo "Viaje eliminado con éxito.\n";
        } else {
            echo "Error al eliminar el viaje: " . $this->db->getError();
        }
    }

    private function existeViaje($idViaje) {
        $this->db->Iniciar();
        $sql = "SELECT * FROM viaje WHERE idviaje = $idViaje";
        $this->db->Ejecutar($sql);
        $resultado = $this->db->Registro();
        return $resultado != null;
    }

    // Métodos para gestionar responsables de viaje------------------------------------------------------------
    public function agregarResponsable($nombre, $apellido, $numLicencia) {
        $this->db->Iniciar();
        $sql = "INSERT INTO responsable (rnombre, rapellido, rnumerolicencia) VALUES ('$nombre', '$apellido', $numLicencia)";
        if ($this->db->Ejecutar($sql)) {
            echo "Responsable agregado con éxito.\n";
        } else {
            echo "Error al agregar el responsable: " . $this->db->getError();
        }
    }

    public function modificarResponsable($numEmpleado, $nombre, $apellido, $numLicencia) {
        $this->db->Iniciar();
        $sql = "UPDATE responsable SET rnombre='$nombre', rapellido='$apellido', rnumerolicencia=$numLicencia WHERE rnumeroempleado=$numEmpleado";
        if ($this->db->Ejecutar($sql)) {
            echo "Responsable modificado con éxito.\n";
        } else {
            echo "Error al modificar el responsable: " . $this->db->getError();
        }
    }

    public function eliminarResponsable($numEmpleado) {
        $this->db->Iniciar();
        $sql = "DELETE FROM responsable WHERE rnumeroempleado=$numEmpleado";
        if ($this->db->Ejecutar($sql)) {
            echo "Responsable eliminado con éxito.\n";
        } else {
            echo "Error al eliminar el responsable: " . $this->db->getError();
        }
    }

private function existeEmpleado($numEmpleado) {
    $this->db->Iniciar();
    $sql = "SELECT * FROM responsable WHERE rnumeroempleado = $numEmpleado";
    $this->db->Ejecutar($sql);
    $resultado = $this->db->Registro();
    return $resultado != null;
}

    // Métodos para gestionar pasajeros------------------------------------------------------------------
    public function agregarPasajero($documento, $nombre, $apellido, $telefono, $idviaje) {
        $this->db->Iniciar();
        $sql = "INSERT INTO pasajero (pdocumento, pnombre, papellido, ptelefono, idviaje) 
                VALUES ('$documento', '$nombre', '$apellido', $telefono, $idviaje)";
        if ($this->db->Ejecutar($sql)) {
            echo "Pasajero agregado con éxito.\n";
        } else {
            echo "Error al agregar el pasajero: " . $this->db->getError();
        }
    }

    public function modificarPasajero($documento, $nombre, $apellido, $telefono, $idviaje) {
        $this->db->Iniciar();
        $sql = "UPDATE pasajero SET pnombre='$nombre', papellido='$apellido', ptelefono=$telefono, idviaje=$idviaje 
                WHERE pdocumento='$documento'";
        if ($this->db->Ejecutar($sql)) {
            echo "Pasajero modificado con éxito.\n";
        } else {
            echo "Error al modificar el pasajero: " . $this->db->getError();
        }
    }

    public function eliminarPasajero($documento) {
        $this->db->Iniciar();
        $sql = "DELETE FROM pasajero WHERE pdocumento='$documento'";
        if ($this->db->Ejecutar($sql)) {
            echo "Pasajero eliminado con éxito.\n";
        } else {
            echo "Error al eliminar el pasajero: " . $this->db->getError();
        }
    }

    public function existeDocumentoPasajero($documento) {
        $this->db->Iniciar();
        $sql = "SELECT pdocumento FROM pasajero WHERE pdocumento = '$documento'";
        $this->db->Ejecutar($sql);
        $resultado = $this->db->Registro();
        return $resultado != null;
    }


    //------------------------ Menú General y Submenús -------------------------------

    public function menuGeneral() {
        do {
            echo "\nMENU GENERAL\n";
            echo "(1) VIAJES\n";
            echo "(2) PASAJEROS\n";
            echo "(3) RESPONSABLE VIAJE\n";
            echo "(4) EMPRESA\n";
            echo "(x) SALIR\n";
            echo "Ingrese una opción: ";
            $opcion = trim(fgets(STDIN)); 

            switch ($opcion) {
                case '1':
                    $this->menuViajes();
                    break;
                case '2':
                    $this->menuPasajeros();
                    break;
                case '3':
                    $this->menuResponsables();
                    break;
                case '4':
                    $this->menuEmpresas();
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

    private function menuViajes() {
        echo "\n--- GESTIONAR VIAJES ---\n";
        echo "(1) Agregar Viaje\n(2) Modificar Viaje\n(3) Eliminar Viaje\n(x) Volver\n";
        $opcion = trim(fgets(STDIN));
        switch ($opcion) {
            case '1':


                echo "Ingrese el destino del viaje: ";
    $destino = trim(fgets(STDIN));

    echo "Ingrese la cantidad máxima de pasajeros: ";
    $cantMaxPasajeros = (int)trim(fgets(STDIN));

    echo "Ingrese el ID de la empresa responsable del viaje: ";
    $idEmpresa = (int)trim(fgets(STDIN));
    if (!$this->existeEmpresa($idEmpresa)) {
        echo "ID de empresa no válido.\n";
        return;
    }

    echo "Ingrese el número de empleado responsable del viaje: ";
    $numEmpleado = (int)trim(fgets(STDIN));
    if (!$this->existeEmpleado($numEmpleado)) {
        echo "Número de empleado no válido.\n";
        return;
    }

    echo "Ingrese el importe del viaje: ";
    $importe = (float)trim(fgets(STDIN));

    
    $this->agregarViaje($destino, $cantMaxPasajeros, $idEmpresa, $numEmpleado, $importe);
                break;


            case '2':
                echo "ingresar idViaje: ";
                $idV=trim(fgets(STDIN));

                if ($this->existeViaje($idV)) {
                    echo "Ingrese el destino del viaje: ";
                    $destino = trim(fgets(STDIN));
                
                    echo "Ingrese la cantidad máxima de pasajeros: ";
                    $cantMaxPasajeros = (int)trim(fgets(STDIN));
                
                    echo "Ingrese el ID de la empresa responsable del viaje: ";
                    $idEmpresa = (int)trim(fgets(STDIN));
                    if (!$this->existeEmpresa($idEmpresa)) {
                        echo "ID de empresa no válido.\n";
                        return;
                    }
                
                    echo "Ingrese el número de empleado responsable del viaje: ";
                    $numEmpleado = (int)trim(fgets(STDIN));
                    if (!$this->existeEmpleado($numEmpleado)) {
                        echo "Número de empleado no válido.\n";
                        return;
                    }
                
                    echo "Ingrese el importe del viaje: ";
                    $importe = (float)trim(fgets(STDIN));

                    $this->modificarViaje($idV, $destino, $cantMaxPasajeros, $idEmpresa, $numEmpleado, $importe);
                    

                }else {
                    echo "no existe viaje";
                }

                break;
            case '3':

                echo "ingresar idviaje: ";
                $idV=trim(fgets(STDIN));
                if ($this->existeViaje($idV)) {
                    $this->eliminarViaje($idV);
                }else {
                    echo "no existe viaje";
                }
                break;
            case 'x':
                return;
            default:
                echo "Opción no válida.\n";
        }
    }

    private function menuPasajeros() {
        echo "\n--- GESTIONAR PASAJEROS ---\n";
        echo "(1) Agregar Pasajero\n(2) Modificar Pasajero\n(3) Eliminar Pasajero\n(x) Volver\n";
        $opcion = trim(fgets(STDIN));
        switch ($opcion) {
            case '1':
                echo "INGRESE NOMBRE: ";
                $nombreP =trim(fgets(STDIN));
                echo "ingrese apellido: ";
                $apellidoP =trim(fgets(STDIN));
                echo "ingrese documento: ";
                $dni =trim(fgets(STDIN));
                echo "ingrese telefono: ";
                $numTelefono =trim(fgets(STDIN));
                echo "ingrese id viaje: ";
                $idV=trim(fgets(STDIN));
                if ($this->existeViaje($idV)) {
                $this->agregarPasajero($dni, $nombreP, $apellidoP, $numTelefono, $idV);
                }else {
                    echo "no existe viaje";
                }
                

                break;
            case '2':
                echo "ingresar documento:";
                $dni=trim(fgets(STDIN));
                if ($this->existeDocumentoPasajero($dni)) {
                    echo "INGRESE NOMBRE: ";
                $nombreP =trim(fgets(STDIN));
                echo "ingrese apellido: ";
                $apellidoP =trim(fgets(STDIN));
                echo "ingrese telefono: ";
                $numTelefono =trim(fgets(STDIN));
                echo "ingrese id viaje: ";
                $idV=trim(fgets(STDIN));
                if ($this->existeViaje($idV)) {
                $this->modificarPasajero($dni, $nombreP, $apellidoP, $numTelefono, $idV);
                }else {
                    echo "no existe viaje";
                } 
                }else {
                    echo "no existe persona";
                }
                break;
            case '3':
                echo "inrgesar documento: ";
                $dni=trim(fgets(STDIN));
                if ($this->existeDocumentoPasajero($dni)) {
                # code...
                $this->eliminarPasajero($dni);
            }else {
                echo "no existe persona";
            }
                break;
            case 'x':
                return;
            default:
                echo "Opción no válida.\n";
        }
    }

    private function menuResponsables() {
        echo "\n--- GESTIONAR RESPONSABLES ---\n";
        echo "(1) Agregar Responsable\n(2) Modificar Responsable\n(3) Eliminar Responsable\n(x) Volver\n";
        $opcion = trim(fgets(STDIN));
        switch ($opcion) {
            case '1':
                //agregarResponsable($nombre, $apellido, $numLicencia)
                echo "ingrese nombre: ";
                $nombreR=(trim(fgets(STDIN)));
                echo "ingrese apellido: ";
                $apellidoR=(trim(fgets(STDIN)));
                echo "ingrese num licencia: ";
                $numL=(trim(fgets(STDIN)));

                $this->agregarResponsable($nombreR, $apellidoR, $numL);
                
                break;
            case '2':

                echo "Ingrese el número del empleado a modificar: ";
            $numE = trim(fgets(STDIN));
           
            if ($this->existeEmpleado($numE)) {
                echo "Ingrese el nuevo nombre del empleado: ";
                $nombre = trim(fgets(STDIN));
                echo "Ingrese el nuevo apellido del empleado: ";
                $apellido = trim(fgets(STDIN));
                echo "Ingrese el nuevo número de licencia del empleado: ";
                $numLicencia = trim(fgets(STDIN));
               
                $this->modificarResponsable($numE, $nombre, $apellido, $numLicencia);
            } else {
                echo "Número de empleado no encontrado.\n";
            }
                break;

            case '3':
                echo "ingrese num empleado: ";
                $numE=trim(fgets(STDIN));
                if ($this->existeEmpleado($numE)) {    
                    $this->eliminarResponsable($numE);
                }else {
                    echo "no existe empleado";
                }
                
                break;
            case 'x':
                return;
            default:
                echo "Opción no válida.\n";
        }
    }

    private function menuEmpresas() {
        echo "\n--- GESTIONAR EMPRESAS ---\n";
        echo "(1) Agregar Empresa\n(2) Modificar Empresa\n(3) Eliminar Empresa\n(x) Volver\n";
        $opcion = trim(fgets(STDIN));
        switch ($opcion) {
            case '1':
                echo "nombre empresa: ";
                $nombreE=trim(fgets(STDIN));
                echo "direccion: ";
                $direccionE=trim(fgets(STDIN));
               
                $this->agregarEmpresa($nombreE, $direccionE);
                break;
            case '2':

                echo "Ingrese el ID de la empresa a modificar: ";
                $idempresa = trim(fgets(STDIN));
    
                if ($this->existeEmpresa($idempresa)) {
                    echo "Ingrese el nuevo nombre de la empresa: ";
                    $enombre = trim(fgets(STDIN));
                    echo "Ingrese la nueva dirección de la empresa: ";
                    $edireccion = trim(fgets(STDIN));
    
                    $this->modificarEmpresa($idempresa, $enombre, $edireccion);
                } else {
                    echo "ID de empresa no encontrado.\n";
                }
                break;
            case '3':

                echo "ingresar id de empresa a eliminar: ";
                $idE=trim(fgets(STDIN));
                $this->eliminarEmpresa($idE);
                
                break;
            case 'x':
                return;
            default:
                echo "Opción no válida.\n";
        }
    }
}


$testViajes = new TestViajes();
$testViajes->menuGeneral();
?>
