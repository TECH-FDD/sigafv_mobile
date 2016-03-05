<?php

class BaseDatos {
    var $HOSTNAME;
    var $BASEDATOS;
    var $USUARIO;
    var $CLAVE;
    var $CONEXION;
    private $QUERY;
    private $RESULT;
    private $ERROR;
/**
 * Constructor de la clase que inicia ls variables instancias de la clase 
 * vinculadas a la coneccion con el Servidor de BD
 */
    public function __construct(){
        $this->HOSTNAME = "localhost";
        $this->BASEDATOS = "qts";
        $this->USUARIO = "root";
        $this->CLAVE = "12qwaszx";
        $this->RESULT = 0;
        $this->QUERY = "";
        $this->ERROR = "";
    }
/**
 * Funcion que retorna una cadena 
 * con una pequeña descripcion del error si lo hubiera 
 *
 * @return cadena
 */	
    public function getError(){
        return $this->ERROR;
    }

/**
 * Inicia la coneccion con el Servidor y la  Base Datos Mysql. 
 * Retorna true si la coneccion con el servidor se pudo establecer y false en caso contrario
 *
 * @return boolean
 */
   public function Iniciar(){
      $conexion = mysql_connect($this->HOSTNAME, $this->USUARIO, $this->CLAVE, true);
      if ($conexion){
         if (mysql_select_db($this->BASEDATOS, $conexion)){
            $this->CONEXION = $conexion;
            unset($this->QUERY);
            unset($this->ERROR);
            return true;
         }else{   
            $this->ERROR = mysql_errno($conexion);
            return false;
         }
      }else{
         $this->ERROR =  mysql_errno($conexion); 
         return false;
      }
   }
	
/**
 * Ejecuta una consulta en la Base de Datos. 
 * Recibe la consulta en una cadena enviada por parametro.
 *
 * @param cadena $consulta
 * @return boolean
 */	
   public function Ejecutar($consulta){
      unset($this->ERROR);
      $this->QUERY = $consulta;
      if ($this->RESULT = mysql_query($consulta)){
         return true;
      }else{
         $this->ERROR = mysql_errno($this->CONEXION) . ": " . mysql_error($this->CONEXION);
         return false;
      }
   }

/**
 * Devuelve un registro retornado por la ejecucion de una consulta 
 * el puntero se despleza al siguiente registro de la consulta
 *
 * @return unknown
 */
    public function Registro() {
      if ($this->RESULT){
         if ($temp = mysql_fetch_object($this->RESULT)) {
            return $temp;
         }else{
            mysql_free_result($this->RESULT);
            return false;
         }
      }else{
        $this->ERROR = mysql_errno($this->CONEXION) . ": " . mysql_error($this->CONEXION);
        return false;
      }
    }

/**
 * Devuelve el id de un campo autoincrement utilizado como clave de una tabla
 * Retorna el id numerico del registro insertado, devuelve null en caso que la ejecucion de la consulta falle
 *
 * @param cadena $consulta
 * @return id de la tupla insertada
 */
    public function devuelveIDInsercion($consulta){
        unset($this->ERROR);
        $this->QUERY = $consulta;
        if ($this->RESULT = mysql_query($consulta)){
            $id = mysql_insert_id();
            return $id;
        }else{
            $this->ERROR = mysql_errno($this->CONEXION) . ": " . mysql_error($this->CONEXION);
            return null;
        }
    }

/**
 * Finaliza una conexion
 *
 */
   public function Finalizar(){
      mysql_close($this->CONEXION);
      unset($this->CONEXION);
   }

/**
 * Devuelve la cantidad de registros de la ultima consulta ejecutada
 *
 * @return int
 */
   public function Cantidad(){
      return mysql_num_rows($this->RESULT);
   }

   public function Conexion(){
      return $this->CONEXION;
   }

}
?>
