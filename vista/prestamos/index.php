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
          <h1><i class="far fa-newspaper"></i> PRESTAMOS</h1>
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
            <button id="btnnuevo" class="btn btn-primary btn-block mg-b-10"><i class="fas fa-plus-circle"></i> Nuevo Prestamo</button>
            <div class="card-header">
              <h3 class="card-title">Mantenimiento de Prestamos </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="prestamos_data" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Cod.</th>
                    <th>Empresa: </th>
                    <th>Banco: </th>
                    <th>Num Prestamo: </th>
                    <th>Monto Total: </th>
                    <th>Saldo Actual: </th>
                    <th>Fecha Otorga: </th>
                    <th> Editar</th>
                    <th> Borrar</th>

                  </tr>
                </thead>
                <tbody>

                </tbody>
                <tfoot>

                  <tr>
                    <th colspan="5">

                    </th>
                  </tr>

                </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <div id="modalmantenimiento" class="modal fade bd-example-modal" tabindex="-1" role="modal" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <form method="post" id="prestamos_form">
              <div class="modal-header d-flex justify-content-center">
                <h4 class="modal-title" id="mdltitulo"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true" style="color:white">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <input type="hidden" id="id_prestamo" name="id_prestamo">
                <div class="row">
                  <div class="col-md-2">
                    <div class="form-group">
                      <label class="form-label" for="id_prestamo">Cod. </label>
                      <input type="text" class="form-control" name="cod_prestamo" id="cod_prestamo" placeholder="Cod" readonly>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label" for="cmb_empresa">Empresa: </label><span style="color:red"> * </span>
                      <select name="id_empresa" id="combo_empresa" class="form-control select2 select2bs4" required>
                        <option value="">Seleccione</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="form-label" for="id_banco">Banco: </label><span style="color:red"> * </span>
                      <select name="id_banco" id="combo_banco" class="form-control select2 select2bs4" required>
                        <option value="">Seleccione</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="form-label" for="NumPrestamo">Num Prestamo. </label><span style="color:red"> * </span>
                      <input type="text" class="form-control" id="NumPrestamo" name="NumPrestamo" placeholder="Numero de prestamo" required>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label class="form-label" for="montototal">Monto Total: </label><span style="color:red"> * </span>
                      <input type="text" class="form-control" id="montototal" name="montototal" placeholder="0.00" required>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label class="form-label" for="SaldoActual">Saldo Actual: </label><span style="color:red"> * </span>
                      <input type="text" class="form-control" id="SaldoActual" name="SaldoActual" placeholder="0.00" required>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label class="form-label" for="tasa"> Tasa: </label>
                      <input type="text" class="form-control" id="tasa" name="tasa" placeholder="0.0" required>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label class="form-label" for="PagoMensual">Pago Mensual: </label><span style="color:red"> * </span>
                      <input type="text" class="form-control" id="PagoMensual" name="PagoMensual" placeholder="0.00" required>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Fecha Otorgado:</label>
                      <div class="input-group date" id="reservationdate" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" name="FechaOtorgamiento" id="FechaOtorgamiento" data-target="#reservationdate" />
                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                      </div>
                    </div>

                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Fecha finalizacion:</label>
                      <div class="input-group date" id="reservationdate2" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" name="fechaVencimiento" id="fechaVencimiento" data-target="#reservationdate2" imputmask />
                        <div class="input-group-append" data-target="#reservationdate2" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-rounded btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="submit" name="action" id="#" value="add" class="btn btn-rounded btn-primary">Guardar</button>
              </div>
            </form>
          </div>
        </div>
      </div>

    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>

<?php include "../../public/templates/footer.php" ?>
<script type="text/javascript" src="prestamos.js"></script>