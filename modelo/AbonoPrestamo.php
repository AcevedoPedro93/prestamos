<?php
class AbonoPrestamo extends Conectar
{
    public function get_abonoprestamo()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT a.id_abonoprestamo, p.numPrestamo as prestamo, a.Num_referencia, b.nombre as banco, c.numeroCuenta as cuenta, c.id_cuentaEmpresa, a.montoPago, a.nuevosaldo, a.fechaPago ";
        $sql .= " FROM abonosprestamos a ";
        $sql .= " INNER JOIN prestamos p ";
        $sql .= " ON p.id_prestamo = a.id_prestamo ";
        $sql .= " INNER JOIN bancos b ";
        $sql .= " ON b.id_banco = a.id_banco ";
        $sql .= " INNER JOIN cuentasempresa c ";
        $sql .= " ON c.id_cuentaEmpresa = a.id_cuentaEmpresa ";
        $sql .= " WHERE a.estadoReg = 1 ";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function update_saldo($id_prestamo, $nuevosaldo)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE prestamos SET SaldoActual = ? WHERE id_prestamo = ? ";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $nuevosaldo);
        $sql->bindValue(2, $id_prestamo);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function filtrar_prestamo($id_prestamo){
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT a.id_abonoprestamo, a.id_prestamo, p.numPrestamo as prestamo, a.Num_referencia, b.nombre as banco, c.numeroCuenta as cuenta, a.id_cuentaEmpresa, a.montoPago, a.nuevosaldo, a.fechaPago ";
        $sql .= " FROM abonosprestamos a ";
        $sql .= " INNER JOIN prestamos p ";
        $sql .= " ON p.id_prestamo = a.id_prestamo ";
        $sql .= " INNER JOIN bancos b ";
        $sql .= " ON b.id_banco = a.id_banco ";
        $sql .= " INNER JOIN cuentasempresa c ";
        $sql .= " ON c.id_cuentaEmpresa = a.id_cuentaEmpresa ";
        $sql .= " WHERE a.estadoReg = 1 AND a.id_prestamo = ? ";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_prestamo);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function validar_referencia($numReferencia)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM abonosprestamos WHERE Num_referencia = ? ";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $numReferencia);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function get_abonoprestamo_x_id($id_abonoprestamo)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM abonosprestamos WHERE id_abonoprestamo = ? ";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_abonoprestamo);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function delete_abonoprestamo($id_abonoprestamo, $usuarioMod)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE abonosprestamos
                SET
                    estadoReg=0,
                    usuarioMod = ?,
                    fechaMod = now()
                WHERE
                    id_abonoprestamo = ? ";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usuarioMod);
        $sql->bindValue(2, $id_abonoprestamo);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function insert_abonoprestamo($id_prestamo, $Num_referencia, $id_banco, $id_cuentaEmpresa, $saldoactual, $montoPago, $nuevosaldo, $fechaPago, $Comentario, $Capital, $Intereses, $cantMora, $cantSeguro, $Cant_iva, $usuarioReg)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO abonosprestamos (id_prestamo, Num_referencia, id_banco, id_cuentaEmpresa, saldoactual, montoPago, nuevosaldo, fechaPago, comentario, capital, intereses, cantMora, cantSeguro, cant_iva, usuarioReg ) 
                                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_prestamo);
        $sql->bindValue(2, $Num_referencia);
        $sql->bindValue(3, $id_banco);
        $sql->bindValue(4, $id_cuentaEmpresa);
        $sql->bindValue(5, $saldoactual);
        $sql->bindValue(6, $montoPago);
        $sql->bindValue(7, $nuevosaldo);
        $sql->bindValue(8, $fechaPago);
        $sql->bindValue(9, $Comentario);
        $sql->bindValue(10, $Capital);
        $sql->bindValue(11, $Intereses);
        $sql->bindValue(12, $cantMora);
        $sql->bindValue(13, $cantSeguro);
        $sql->bindValue(14, $Cant_iva);
        $sql->bindValue(15, $usuarioReg);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function update_abonoprestamo($id_abonoprestamo, $id_prestamo, $Num_referencia, $id_banco, $id_cuentaEmpresa, $saldoactual, $montoPago, $nuevosaldo, $fechaPago, $Comentario, $Capital, $Intereses, $cantMora, $cantSeguro, $Cant_iva, $usuarioMod)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE abonosprestamos
                SET
                id_prestamo = ?,
                Num_referencia = ?,
                id_banco = ?,
                id_cuentaEmpresa = ?,
                saldoactual = ?,
                montoPago = ?,
                nuevosaldo = ?,
                fechaPago   = ?,
                comentario = ?,
                capital = ?,
                intereses = ?,
                cantMora = ?,
                cantSeguro = ?,
                cant_iva = ?,
                usuarioMod = ?,
                fechaMod=now()
                WHERE
                    id_abonoprestamo = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_prestamo);
        $sql->bindValue(2, $Num_referencia);
        $sql->bindValue(3, $id_banco);
        $sql->bindValue(4, $id_cuentaEmpresa);
        $sql->bindValue(5, $saldoactual);
        $sql->bindValue(6, $montoPago);
        $sql->bindValue(7, $nuevosaldo);
        $sql->bindValue(8, $fechaPago);
        $sql->bindValue(9, $Comentario);
        $sql->bindValue(10, $Capital);
        $sql->bindValue(11, $Intereses);
        $sql->bindValue(12, $cantMora);
        $sql->bindValue(13, $cantSeguro);
        $sql->bindValue(14, $Cant_iva);
        $sql->bindValue(15, $usuarioMod);
        $sql->bindValue(16, $id_abonoprestamo);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
}
