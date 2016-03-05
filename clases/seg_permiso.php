<?php

class Permiso{
    var $codigo;
    var $descripcion;
    var $rol;
    var $itemSeguridad;
    var $alta;
    var $baja;
    var $modifica;
    var $ver;

    public function __construct(){
        $this->codigo = 0;
        $this->descripcion = "";
        $this->rol = 0;
        $this->itemSeguridad = 0;
        $this->alta = 0;
        $this->baja = 0;
        $this->modifica = 0;
        $this->ver = 0;
    }

    function buscar($rol, $itemSeguridad){
        $base = new BaseDatos();
        if ($base->Iniciar()){
            $sql = "select * from seg_permiso where rol='$rol' and itemSeguridad='$itemSeguridad'";
            if ($base->Ejecutar($sql)){
                if ($base->Cantidad() == 1){
                    $fila = $base->Registro();
                    $this->codigo = $fila->codigo;
                    $this->descripcion = $fila->descripcion;
                    $this->rol = $fila->rol;
                    $this->itemSeguridad = $fila->itemSeguridad;
                    $this->alta = $fila->alta;
                    $this->baja = $fila->baja;
                    $this->modifica = $fila->modifica;
                    $this->ver = $fila->ver;
                }
            }
        }
    }
    
}
?>
