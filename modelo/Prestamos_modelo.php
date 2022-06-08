<?php
    class Prestamo extends Conectar{
        public function get_prestamo(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT p.id_prestamo, e.nombre as empresa, b.nombre as banco, p.Numprestamo, p.montototal, p.SaldoActual, p.fechaOtorgamiento ";
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

        public function get_prestamo_x_id($id_prestamo){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM prestamos WHERE id_prestamo = ? ";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id_prestamo);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function delete_prestamo($id_prestamo){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE prestamos
                SET
                    estadoReg=0,
                    id_usuarioMod = 2,
                    fechaMod = now()
                   
                WHERE
                    id_prestamo = ? ";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1,$id_prestamo);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function insert_prestamo($id_empresa, $id_banco, $NumPrestamo, $montototal, $SaldoActual, $tasa, $PagoMensual, $FechaOtorgamiento, $fechaVencimiento){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="INSERT INTO prestamos (id_empresa, id_banco, NumPrestamo, montototal, SaldoActual, tasa, PagoMensual, FechaOtorgamiento, fechaVencimiento) 
                                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
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
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function update_prestamo($id_prestamo,$id_empresa,$id_banco,$NumPrestamo,$montototal,$SaldoActual,$tasa,$PagoMensual,$FechaOtorgamiento,$fechaVencimiento){
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
                    id_usuarioMod = 2,
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
            $sql->bindValue(10,$id_prestamo);
            $sql->execute();
            return $resultado=$sql->fetchAll();
           // die(json_encode($resultado));
             /* echo "<pre>"; array para visualizar lo que trae el query
                    var_dump($producto);
                      echo "</pre>"*/
        }
    }
?>