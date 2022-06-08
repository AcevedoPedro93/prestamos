<?php

include "../../config/conexion.php";
include "../../public/templates/head.php";
include "../../public/templates/header.php";
include "../../public/templates/aside.php";

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="far fa-newspaper"></i> Mantenimiento de Abonos a Prestamos</h1>
                </div>

            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card">
                        <button id="btnnuevoabono" class="btn btn-primary btn-block mg-b-10"><i class="fas fa-plus-circle"></i> Nuevo Abono</button>
                        <input type="hidden" id="idcuentaempresa" name="idcuentaempresa">
                        <!-- /.card-header -->
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-6">
                                    <form action="">
                                        <h5><strong>SELECCIONE PRESTAMO PARA MOSTRAR DATOS</strong></h5>
                                        <div class="form-group">
                                            <label class="form-label" for="combo_prestamo">Prestamo: </label><span style="color:red"> * </span>
                                            <select name="id_prestamo" id="combo_prestamo" class="form-control select2 select2bs4" onchange=cargarDataTable();>
                                                <option value="">Seleccione</option>
                                            </select>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-6 button-container">
                                    
                                </div>         
                            </div>
                            <table id="AbonosPrestamos_data" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Cod.</th>
                                        <th>Nro. Prestamo: </th>
                                        <th>Referencia: </th>
                                        <th>Banco: </th>
                                        <th>Cuenta: </th>
                                        <th>Monto Abono: </th>
                                        <th>Saldo Actual: </th>
                                        <th>Fecha Abono: </th>
                                        <th>Editar</th>
                                        <th>Borrar</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>

                                    <tr>
                                        <th colspan="6">

                                        </th>
                                    </tr>

                                </tfoot>
                            </table>

                            <!--INICIO MODAL -->
                            <div id="modalAbonosPrestamo" class="modal fade bd-example-modal" tabindex="-1" role="modal" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <form method="post" id="abonosprestamos_form">
                                            <div class="modal-header d-flex justify-content-center">
                                                <h4 class="modal-title " id="mdltitulo"></h4>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" id="id_abonoprestamo" name="id_abonoprestamo">
                                                <div class="form-group row">
                                                    <div class="col-md-2">
                                                        <label class="form-label" for="cod_abonoPrestamo">Cod. </label>
                                                        <input type="text" class="form-control" id="cod_abonoPrestamo" name="cod_abonoPrestamo">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label" for="id_prestamo">Prestamo: </label><span style="color:red; "> * </span>
                                                        <select name="id_prestamo" id="id_prestamo" class="form-control select2 select2bs4" required>
                                                            <option value="">Seleccione</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label" for="referencia">Num de Referencia: </label><span style="color:red; "> * </span>
                                                        <input type="text" class="form-control" id="referencia" name="referencia" placeholder="Numero de prestamo" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-5">
                                                        <label class="form-label" for="id_banco">Banco: </label><span style="color:red; "> * </span>
                                                        <select name="id_banco" id="combo_banco" class="form-control select2 select2bs4" required>
                                                            <option value="">Seleccione</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-7">
                                                        <label class="form-label" for="id_cuentaEmpresa">Cuenta: </label><span style="color:red; "> * </span>
                                                        <input type="hidden" id="id_cuenta" name="id_cuenta">
                                                        <select name="id_cuentaEmpresa" id="combo_cuenta" value="" class="form-control select2 select2bs4" required>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-2">
                                                        <label class="form-label" for="saldoactual">Saldo Actual: </label>
                                                        <input type="text" class="form-control" id="saldoactual" name="saldoactual" placeholder="0.00" readonly>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label" for="montoPago">Monto Pago: </label><span style="color:red; "> * </span>
                                                        <input type="text" class="form-control" id="montoPago" name="montoPago" placeholder="0.00" required>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label" for="nuevoSaldo">Nuevo Saldo: </label>
                                                        <input type="text" class="form-control" id="nuevoSaldo" name="nuevoSaldo" placeholder="0.00" readonly onkeyup=nuevosaldo();>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Fecha de Pago:</label>
                                                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                                                <input type="text" class="form-control datetimepicker-input" name="fechaPago" id="fechaPago" data-target="#reservationdate" />
                                                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label" for="comentario"> Comentario: </label>
                                                        <input type="text" class="form-control" id="comentario" name="comentario" placeholder="Comentario">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3">
                                                        <label class="form-label" for="capital">Abono a Capital: </label>
                                                        <input type="text" class="form-control" id="capital" name="capital" placeholder="0.00">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label" for="interes"> Interes: </label>
                                                        <input type="text" class="form-control" id="interes" name="interes" placeholder="0.00">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label" for="mora">Mora: </label>
                                                        <input type="text" class="form-control" id="mora" name="mora" placeholder="0.00">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label" for="seguro">Seguro: </label>
                                                        <input type="text" class="form-control" id="seguro" name="seguro" placeholder="0.00">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label" for="iva">Iva: </label>
                                                        <input type="text" class="form-control" id="iva" name="iva" placeholder="0.00">
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" onclick=closemodal(); class="btn btn-rounded btn-danger" data-dismiss="modal">Cerrar</button>
                                                <button type="submit" name="action" id="#" value="add" class="btn btn-rounded btn-primary">Guardar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- FINAL MODAL-->
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<?php include "../../public/templates/footer.php" ?>
<script type="text/javascript" src="abonosprestamos.js"></script>

