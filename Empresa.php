<?php

//<>
//<>
include_once "Cliente.php";
include_once "Venta.php";
include_once "Moto.php";
class Empresa{

    private $denominacion;
    private $direccion;
    private $collClientes;
    private $collecMoto;
    private $collVentas;

    public function __construct($denominacionC,$direccionC, $colClientesC, $colMotosC, $colVentasC){
        $this->denominacion = $denominacionC;
        $this->direccion = $direccionC;
        $this->collClientes = $colClientesC;
        $this->collecMoto = $colMotosC;
        $this->collVentas = $colVentasC; 
    }

    public function getDenonimacion(){
        return $this->denominacion;
    }
    public function getDireccion(){
        return $this->direccion ;
    }
    public function getCollClientes(){
        return $this->collClientes;
    }
    public function getCollecMoto(){
        return $this->collecMoto ;
    }
    public function getCollventas(){
        return $this->collVentas;
    }

    public function setDenominacion($denominacionSet){
        $this->denominacion = $denominacionSet;
    }
    public function setDireccion($direccionSet){
        $this->direccion = $direccionSet;
    }
    public function setCollClientes($collClientesSet){
        $this->collClientes = $collClientesSet;
    }
    public function setCollecMoto($collecMotoSet){
        $this->collecMoto = $collecMotoSet;
    }
    public function setCollVentas($collVentasSet){
        $this->collVentas = $collVentasSet;
    }

    public function __toString(){
        $motosString = "";
        $clientesString="";
        $ventaString="";
        foreach ($this->getCollecMoto() as $moto) {
            $motosString .= $moto . "\n"; // Utiliza el método __toString() de la clase Moto
        }
        foreach($this->getCollClientes() as $client){
            $clientesString .= $client . "\n";
        }
        foreach($this->getCollventas() as $venta){
            $ventaString .= $venta . "\n";   
        }
        return  "------------------------------------------"."\n".
                "Denominacion: ".$this->getDenonimacion()."\n".
                "------------------------------------------"."\n".
                "Direccion: ".$this->getDireccion()."\n".
                "------------------------------------------"."\n".
                "Coleccion clientes: ".$clientesString."\n".
                "------------------------------------------"."\n".
                "Coleccion de motos: ".$motosString."\n".
                "------------------------------------------"."\n".
                "Coleccion ventas: ".$ventaString."\n".
                "------------------------------------------";
    }

//5. Implementar el método  que recorre la colección de motos de la Empresa y retorna la referencia al objeto moto cuyo código coincide con el recibido por parámetro.

    public function  retornarMoto($codigoMoto){
        $colMotos=$this->getCollecMoto();
        foreach ($colMotos as $moto){
            if($moto->getCodigoMoto() == $codigoMoto){
                return $moto;
            }
        }
        return null; 
}


/* 6. Implementar el método  método que recibe poparámetro una colección de códigos de motos, la cual es recorrida, y por cada elemento de la colección se busca el objeto moto correspondiente al código y se incorpora a la colección de motos de la instancia Venta que debe ser creada. Recordar que no todos los clientes ni todas las motos, están disponibles para registrar una venta en un momento determinado.
    El método debe setear los variables instancias de venta que corresponda y retornar el importe final de la
    venta.*/
    public function registrarVenta($colCodigosMoto, $objCliente){
        $arrayMotos=[];
        $importeFinal = 0; 
        $cantVenta = count($this->getCollVentas());
        
        foreach($colCodigosMoto as $recorrer){
            $motos = $this->retornarMoto($recorrer); 
    
            if($motos != null && $motos->getActiva()){
                $precio = $motos->darPrecioVenta(); 
                $importeFinal += $precio; 
                $arrayMotos[]= $motos;
                echo "La moto se añadio correctamente"."\n";
            }else{
                echo "La moto no esta activa o no se puede agregar"."\n";
            }
        }
    
        // Crear la venta y establecer la colección de motos
        $venta = new Venta($cantVenta + 1, "01/01/2001", $objCliente, $arrayMotos, $importeFinal); 
    
        // Obtener la colección de ventas actual
        $collVentas = $this->getCollVentas();
    
        // Agregar la nueva venta a la colección
        $collVentas[] = $venta;
    
        // Establecer la nueva colección de ventas
        $this->setCollVentas($collVentas); 
    
        return $venta; 
    }
    

    //Implementar el método  que recibe por parámetro el tipo y número de documento de un Cliente y retorna una colección con las ventas realizadas al cliente.
    public function retornarVentasXCliente($tipo,$numDoc){
        $colVentasCliente = [];
        foreach($this->getCollventas() as $venta){
                if($venta->getRefCliente()->getTipoDocCliente()== $tipo && $venta->getRefCliente()->getNumDocCliente() == $numDoc){
                    array_push($colVentasCliente,$venta);
                }
        }
        return $colVentasCliente;
       
    }

    }