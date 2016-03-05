<?php

class Usuario{
    var $codigo;
    var $nick;
    var $password;
    var $activo;
    var $nombre;
    var $apellido;
    var $coordinado;

    public function __construct(){
        $this->codigo = 0;
        $this->nick = "";
        $this->password = "";
        $this->activo = "";    
        $this->nombre = "";    
        $this->apellido = "";    
        $this->coordinado = "";    
    }

    function Login($nick, $password){
        $base = new BaseDatos();
        //echo $usuario.' '.$pass;
        if ($base->Iniciar()){
            //echo '---'.$id.'---';
            $User = mysql_real_escape_string($nick);
            $Pass = mysql_real_escape_string($pass);
            $sql = "select * from seg_usuario where nick='$nick' and password=sha1('$password') and activo=1";
            if ($base->Ejecutar($sql)){
                if ($base->Cantidad() == 1){
                    $fila = $base->Registro();
                    $this->codigo = $fila->codigo;
                    $this->nick = $fila->nick;
                    $this->password = $fila->password;
                    $this->activo = $fila->activo;
                    $this->nombre = $fila->nombre;    
                    $this->apellido = $fila->apellido;
                    $this->coordinado = $fila->coordinado;
                    $base->Finalizar();
                    return true;
                }
            }
        }
        return false;
    }
   
    function Logout(){
        session_destroy();
    }

    function buscarId($codigo){
        $base = new BaseDatos();
        //echo $usuario.' '.$pass;
        if ($base->Iniciar()){
            //echo '---'.$id.'---';
            $sql = "select * from seg_usuario where codigo=$codigo and activo=1";
            if ($base->Ejecutar($sql)){
                if ($base->Cantidad() == 1){
                    $fila = $base->Registro();
                    $this->codigo = $fila->codigo;
                    $this->nick = $fila->nick;
                    $this->password = $fila->password;
                    $this->activo = $fila->activo;
                    $this->nombre = $fila->nombre;    
                    $this->apellido = $fila->apellido;
                    $this->coordinado = $fila->coordinado;
                    $base->Finalizar();
                    return true;
                }
            }
        }
        return false;
    }

    function buscarUser($nick){
        $base = new BaseDatos();
        //echo $usuario.' '.$pass;
        if ($base->Iniciar()){
            //echo '---'.$id.'---';
            $sql = "select * from seg_usuario where nick='$nick'";
            if ($base->Ejecutar($sql)){
                if ($base->Cantidad() == 1){
                    $fila = $base->Registro();
                    $this->codigo = $fila->codigo;
                    $this->nick = $fila->nick;
                    $this->password = $fila->password;
                    $this->activo = $fila->activo;
                    $this->nombre = $fila->nombre;    
                    $this->apellido = $fila->apellido;
                    $this->coordinado = $fila->coordinado;
                    $base->Finalizar();
                    return true;
                }
            }
        }
        return false;
    }

    function guardar(){
        $base = new BaseDatos();
        if ($base->Iniciar()){
            if ($this->codigo > 0){
                $sql = "update seg_usuario set
                        activo='$this->activo'
                        where Codigo='$this->codigo'";
                return $base->Ejecutar($sql);
            }else{
                $sql = "select * from seg_usuario where nick='$this->nick'";
                if ($base->Ejecutar($sql)){
                    if ($base->Cantidad() == 0){
                        $sql = "
                        insert into seg_usuario
                        (nick,activo,pass) 
                        values 
                        ('$this->nick','$this->activo',sha1('$this->nick'))";
                        $this->codigo = $base->devuelveIDInsercion($sql);
                        $base->Finalizar();
                        return $this->codigo;
                    }
                }
            }
        }
        return false;
    }

    function cambiaPass(){
        $base = new BaseDatos();
        if ($base->Iniciar()){
            $sql = "update seg_usuario set password=sha1('$this->password') where codigo='$this->codigo'";
            //echo $sql;
            return $base->Ejecutar($sql);
        }
        return false;
    }

    function borrar(){
        $base = new BaseDatos();
        if ($base->Iniciar()){
            if ($this->codigo > 0){ //update
                $sql = "delete from seg_usuario where codigo='$this->codigo'";
                $base->Ejecutar($sql);
                $base->Finalizar();
            }
        }
    }

    function getCodigo(){
        return $this->codigo;
    }

    function getActivo(){
        return $this->activo;
    }
    
    function setActivo($activo){
        $this->activo = $activo;
    }

    function setPass($password){
        $this->password = $password;
    }
    
    function getNombre(){
        $nombre = $this->apellido;
        if ($this->nombre!="" && $nombre != ""){
            $nombre .= ", ".$this->nombre;
        }else{
            $nombre = $this->nombre;
        }
        return $nombre;
    }
    
    function getNick(){
        return $this->nick;
    }
    
    function setNick($nick){
        $this->nick = $nick;
    }

    function getUsuarios($where = ""){
        $base = new BaseDatos();
        if ($base->Iniciar()){
            $sql = "select Codigo from seg_usuario ".$where;
            if ($base->Ejecutar($sql)){
                $Usuarios = array();
                while ($fila = $base->Registro()){
                    $Usuario = new Usuario();
                    $Usuario->buscarId($fila->Codigo);
                    $Usuarios[] = $Usuario;
                }
                return $Usuarios;
            }
        }
    }

    function getPermiso($item){
        $base = new BaseDatos();
        if ($base->Iniciar()){
            $sql = "select sum(alta) alta,sum(baja) baja,sum(modifica) modifica,sum(ver) ver
                    from seg_usuario_rol ur
                    join(
                        select rol,itemseguridad item,alta,baja,modifica,ver
                        from seg_permiso
                        where itemSeguridad=".$item.") p
                    on p.rol=ur.rol and ur.usuario=".$this->codigo."
                    group by item";
            if ($base->Ejecutar($sql)){
                $fila = $base->Registro();
                return $fila;
            }
        }
        return false;
    }
}
?>
