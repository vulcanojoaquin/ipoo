<?php
include_once "BaseDatos.php";
class Persona{

	private $nombre;
	private $apellido;
	private $documento;
	//private $mensajeoperacion;


	public function __construct(){
		
		$this->nombre = "";
		$this->apellido = "";
		$this->documento = "";
		
	}

	public function cargar($Nom,$Ape, $doc){		
		$this->setNombre($Nom);
		$this->setApellido($Ape);
		$this->setDocumento($doc);
    }
	
	public function setNombre($nombre){
		$this->nombre=$nombre;
	}
	public function setApellido($apellido){
		$this->apellido=$apellido;
	}
	public function setDocumento($doc){
		$this->documento=$doc;
	}
	public function setmensajeoperacion($mensajeoperacion){
		$this->mensajeoperacion = $mensajeoperacion;
	}
	public function getNombre(){
		return $this->nombre ;
	}
	public function getApellido(){
		return $this->apellido ;
	}
	public function getDocumento(){
		return $this->documento ;
	}
	
	public function getmensajeoperacion()
	{
		return $this->mensajeoperacion;
	} 
		

    public function __toString(){
		return "nombre: " . $this->getNombre() . "\napellido: " . $this->getApellido(). "\ndocumento:". $this->getDocumento() ;  
	}
	
    public function Buscar($dni){
		$base=new BaseDatos();
		$consultaPersona="Select * from persona where documento=".$dni;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaPersona)){
				if($row2=$base->Registro()){					
				    $this->setDocumento($dni);
					$this->setNombre($row2['nombre']);
					$this->setApellido($row2['apellido']);
					$resp= true;
				}				
			
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 	
		 }		
		 return $resp;
	}	
    

	public static function listar($condicion=""){
	    $arregloPersona = null;
		$base=new BaseDatos();
		$consultaPersonas="Select * from persona ";
		if ($condicion!=""){
		    $consultaPersonas=$consultaPersonas.' where '.$condicion;
		}
		$consultaPersonas.=" order by apellido ";
		//echo $consultaPersonas;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaPersonas)){				
				$arregloPersona= array();
				while($row2=$base->Registro()){
					
					$NroDoc=$row2['nrodoc'];
					$Nombre=$row2['nombre'];
					$Apellido=$row2['apellido'];
				
					$perso=new Persona();
					$perso->cargar($Nombre,$Apellido,$NroDoc);
					array_push($arregloPersona,$perso);
	
				}
				
			
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 	
		 }	
		 return $arregloPersona;
	}	


	
	public function insertar(){
		$base=new BaseDatos();
		$resp= false;
		$consultaInsertar="INSERT INTO persona(documento, nombre, apellido  ) 
				VALUES ('".$this->getDocumento()."','".$this->getNombre()."','".$this->getApellido()."')";
		
		if($base->Iniciar()){

			if($base->Ejecutar($consultaInsertar)){

			    $resp=  true;

			}	else {
					$this->setmensajeoperacion($base->getError());
					
			}

		} else {
				$this->setmensajeoperacion($base->getError());
			
		}
		return $resp;
	}
	
	
	
	public function modificar(){
	    $resp =false; 
	    $base=new BaseDatos();
		$consultaModifica="UPDATE persona SET nombre='".$this->getNombre()."', apellido='".$this->getApellido()."'
                            WHERE documento=". $this->getDocumento();
		if($base->Iniciar()){
			if($base->Ejecutar($consultaModifica)){
			    $resp=  true;
			}else{
				$this->setmensajeoperacion($base->getError());
				
			}
		}else{
				$this->setmensajeoperacion($base->getError());
			
		}
		return $resp;
	}
	
	public function eliminar(){
		$base=new BaseDatos();
		$resp=false;
		if($base->Iniciar()){
				$consultaBorra="DELETE FROM persona WHERE documento=".$this->getDocumento();
				if($base->Ejecutar($consultaBorra)){
				    $resp=  true;
				}else{
						$this->setmensajeoperacion($base->getError());
					
				}
		}else{
				$this->setmensajeoperacion($base->getError());
			
		}
		return $resp; 
	}

	
}



?>