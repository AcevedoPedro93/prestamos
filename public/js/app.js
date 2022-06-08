$(function () {

  //Initialize Select2 Elements
  $('.select2').select2()

  //Initialize Select2 Elements
  $('.select2bs4').select2({
    theme: 'bootstrap4'
  })

  //Initialize Select2 Elements
  $('.select2').select2()

  //Initialize Select2 Elements
  $('.select2bs4').select2({
    theme: 'bootstrap4'
  })

  $('#reservationdate2').datetimepicker({
    format: 'DD-MM-YYYY'
  });

  //Date picker
  $('#reservationdate2').datetimepicker({
    format: 'DD-MM-YYYY'
  });
  $('#reservationdate').datetimepicker({
    format: 'DD-MM-YYYY'
  });

  //SOLO NUMERO INPUTS
  $('#montototal').on('input', function () {
    this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
  });
  $('#SaldoActual').on('input', function () {
    this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
  });
  $('#tasa').on('input', function () {
    this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
  });
  $('#PagoMensual').on('input', function () {
    this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
  });
  $('#montoPago').on('input', function () {
    this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
  });
  $('#capital').on('input', function () {
    this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
  });
  $('#interes').on('input', function () {
    this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
  });
  $('#mora').on('input', function () {
    this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
  });
  $('#seguro').on('input', function () {
    this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
  });
  $('#iva').on('input', function () {
    this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
  });
  //fin SOLO NUMERO INPUTS

});