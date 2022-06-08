<?php
    class Banco extends Conectar{
           
        public function get_banco(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT id_banco, nombre FROM bancos WHERE estadoReg=1";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
            
        }

    }
?>