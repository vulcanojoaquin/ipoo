<?php
include_once 'BaseDatos.php';
include_once 'Empresa.php';
include_once 'Persona.php';
include_once 'ResponsableV.php';
include_once 'Pasajero.php';
class Viaje{

private $idviaje;
private $destino;
private $cantMaxPasajeros;
private $empresa;
private $responsable;
private $importe;
private $pasajeros = [];

public function __construct($idviaje=null, $destino, $cantMaxPasajeros, Empresa $empresa, ResponsableV $responsable, $importe) {
    $this->idviaje = $idviaje;
    $this->destino = $destino;
    $this->cantMaxPasajeros = $cantMaxPasajeros;
    $this->empresa = $empresa;
    $this->responsable = $responsable;
    $this->importe = $importe;
}

//---------get---------------------------------- 
public function getIdviaje()
{
    return $this->idviaje;
}

public function getDestino()
{
    return $this->destino;
}

public function getCantMaxPasajeros()
{
    return $this->cantMaxPasajeros;
}

public function getEmpresa()
{
    return $this->empresa;
}

 public function getResponsable()
{
    return $this->responsable;
}

public function getImporte()
{
    return $this->importe;
}

 public function getPasajeros()
{
    return $this->pasajeros;
}

//---------set---------------------------------

public function setIdviaje($idviaje)
{
    $this->idviaje = $idviaje;
}

public function setDestino($destino)
{
    $this->destino = $destino;   
}

public function setCantMaxPasajeros($cantMaxPasajeros)
{
    $this->cantMaxPasajeros = $cantMaxPasajeros;
}

public function setEmpresa($empresa)
{
    $this->empresa = $empresa;
}

public function setResponsable($responsable)
{
    $this->responsable = $responsable;   
}

public function setImporte($importe)
{
    $this->importe = $importe;
}

public function setPasajeros(Pasajero $pasajeros)
{
    $this->pasajeros[] = $pasajeros;
}


}



?>