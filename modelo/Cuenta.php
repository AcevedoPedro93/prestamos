<?php
    class Cuenta extends Conectar{
           
        public function get_cuenta($id_banco){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM cuentasempresa WHERE id_banco = ? AND estadoReg=1;";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id_banco);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
    }
?>