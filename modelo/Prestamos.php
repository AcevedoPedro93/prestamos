<?php
    class Prestamo extends Conectar{
        public function get_prestamo(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT p.id_prestamo, e.nombre as empresa, b.nombre as banco, p.Numprestamo, p.montototal, p.saldoActual, p.fechaOtorgamiento ";
            $sql.= " FROM prestamos p ";
            $sql.= " INNER JOIN bancos b ";
            $sql.= " ON b.id_banco = p.id_banco ";
            $sql.= " INNER JOIN empresas e ";
            $sql.= " ON e.id_empresa = p.id_empresa ";
            $sql.= " WHERE p.estadoReg = 1 ";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();

        }

        public function validar_prestamo($NumPrestamo){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT  * FROM prestamos WHERE NumPrestamo = ?  AND estadoReg = 1 ";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $NumPrestamo);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_prestamo_x_id($id_prestamo){
            $conectar= parent::conexion();
            parent::set_names();
            $sql=" SELECT * FROM prestamos WHERE id_prestamo = ? ";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id_prestamo);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function delete_prestamo($id_prestamo, $usuarioMod){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE prestamos
                SET
                    estadoReg=0,
                    usuarioMod = ?,
                    fechaMod = now()
                   
                WHERE
                    id_prestamo = ? ";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1,$usuarioMod);
            $sql->bindValue(2,$id_prestamo);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function insert_prestamo($id_empresa, $id_banco, $NumPrestamo, $montototal, $SaldoActual, $tasa, $PagoMensual, $FechaOtorgamiento, $fechaVencimiento, $usuarioReg){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="INSERT INTO prestamos (id_empresa, id_banco, NumPrestamo, montototal, SaldoActual, tasa, PagoMensual, FechaOtorgamiento, fechaVencimiento, usuarioReg) 
                                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1,$id_empresa);
            $sql->bindValue(2,$id_banco);
            $sql->bindValue(3,$NumPrestamo);
            $sql->bindValue(4,$montototal);
            $sql->bindValue(5,$SaldoActual);
            $sql->bindValue(6,$tasa);
            $sql->bindValue(7,$PagoMensual);
            $sql->bindValue(8,$FechaOtorgamiento);
            $sql->bindValue(9,$fechaVencimiento);
            $sql->bindValue(10,$usuarioReg);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function update_prestamo($id_prestamo,$id_empresa,$id_banco,$NumPrestamo,$montototal,$SaldoActual,$tasa,$PagoMensual,$FechaOtorgamiento,$fechaVencimiento, $usuarioMod){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE prestamos
                SET
                    id_empresa = ?,
                    id_banco = ?,
                    NumPrestamo = ?,
                    montototal = ?,
                    SaldoActual = ?,
                    tasa        = ?,
                    PagoMensual = ?,
                    FechaOtorgamiento = ?,
                    fechaVencimiento = ?,
                    usuarioMod = ?,
                    fechaMod=now()
                WHERE
                    id_prestamo = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1,$id_empresa);
            $sql->bindValue(2,$id_banco);
            $sql->bindValue(3,$NumPrestamo);
            $sql->bindValue(4,$montototal);
            $sql->bindValue(5,$SaldoActual);
            $sql->bindValue(6,$tasa);
            $sql->bindValue(7,$PagoMensual);
            $sql->bindValue(8,$FechaOtorgamiento);
            $sql->bindValue(9,$fechaVencimiento);
            $sql->bindValue(10,$usuarioMod);
            $sql->bindValue(11,$id_prestamo);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
    }
?>