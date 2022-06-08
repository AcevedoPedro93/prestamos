var tabla;

function init() {
    $("#prestamos_form").on("submit", function (e) {
        guardaryeditar(e);
    });
}

$(document).ready(function () {

    $.post("../../controller/empresa.php?op=combo", function (data, status) {
        $('#combo_empresa').html(data);
    });

    $.post("../../controller/banco.php?op=combo", function (data, status) {
        $('#combo_banco').html(data);
    });

    $.post("../../controller/prestamos.php?op=combo", function (data, status) {
        $('#combo_prestamo').html(data);
    });

    $.post("../../controller/cuentas.php?op=combo", function (data, status) {
        $('#combo_cuenta').html(data);
    });

    let date = new Date();
    let fechactual = String(date.getDate()).padStart(2, '0') + '' + String(date.getMonth() + 1).padStart(2, '0') + '' + date.getFullYear();
    tabla = $('#prestamos_data').dataTable({
         buttons: [
            {
                extend: 'excel',
                text: '<i class="fa fa-download"></i> Excel ',
                title: 'Prestamos ' + fechactual,
                exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }
            },

            {
                extend: 'pdf',
                text: '<i class="fa fa-download"></i> PDF',
                title: 'Prestamos ' + fechactual,
                exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }
            },
            {
                extend: 'csv',
                text: '<i class="fa fa-clipboard"></i> CSV',
                title: 'Prestamos '+ fechactual,
                exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }
            },
            {
                extend: 'print',
                text: '<i class="fa fa-print"></i> Imprimir',
                title: 'Prestamos '+ fechactual,
                exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }
            },
         ],
         dom: 'Bfrtip',
        "ajax": {
            url: '../../controller/prestamos.php?op=listar',
            type: "get",
            dataType: "json",
            error: function (e) {
                console.log(e.responseText);
            }
        },
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
        },
      "bDestroy": true,
      "bInfo": true,
        "iDisplayLength": 5,//Por cada 5 registros hace una paginación
        //MOSTRAR SUMA AL FINAL DE LA TABLA
        "footerCallback": function (row, data, start, end, display) {
            var api = this.api(), data;

            var intVal = function (i) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ?
                        i : 0;
            };
             // Total de todo el dato de la tabla
             total = api
             .column(5)
             .data()
             .reduce(function (a, b) {
                 return intVal(a) + intVal(b);
             }, 0);

            // Actualizar footer
            $(api.column(4).footer()).html(
                ' Total Prestamos: $ ' + total.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')
            );
        }
    }).DataTable();
});

//funcion guardar y editar prestamos
function guardaryeditar(e) {
    e.preventDefault();
    var formData = new FormData($("#prestamos_form")[0]);
    $.ajax({
        url: "../../controller/prestamos.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            if (datos == 0) {
                swal.fire('Advertencia', 'El número de prestamo ya existe.', 'warning')
            } else if (datos == 1){
                $('#prestamos_form')[0].reset();
                $('#prestamos_data').DataTable().ajax.reload();
                $('#id_prestamo').val('');
                $('#combo_empresa').val("Seleccione").trigger('change');
                $('#combo_banco').val("Seleccione").trigger('change');
                swal.fire('Registro!', 'Prestamo guardado correctamente.', 'success')
            }else{
                $('#prestamos_form')[0].reset();
                $("#modalmantenimiento").modal('hide');
                $('#prestamos_data').DataTable().ajax.reload();
                swal.fire('Registro!', 'Prestamo actualizado correctamente.', 'success')
            }
        }
    });
}

//funcion para mostrar los datos en el modal segun prestamo seleccionado
function editar(id_prestamo) {
    $('#mdltitulo').html('EDITAR PRESTAMO'); //cambiar titulo
    $.post("../../controller/prestamos.php?op=mostrar", { id_prestamo: id_prestamo }, function (data) {
       data = JSON.parse(data);
        $('#id_prestamo').val(data.cod_prestamo);
        $('#cod_prestamo').val(data.id_prestamo);
        $('#combo_empresa').val(data.id_empresa).trigger('change');//para rellenar el combo y hacer el cambio
        $('#combo_banco').val(data.id_banco).trigger('change');//igual que el anterior
        $('#NumPrestamo').val(data.NumPrestamo);
        $('#montototal').val(data.montototal);
        $('#SaldoActual').val(data.SaldoActual);
        $('#tasa').val(data.tasa);
        $('#PagoMensual').val(data.PagoMensual);
        $('#FechaOtorgamiento').val(data.FechaOtorgamiento);
        $('#fechaVencimiento').val(data.fechaVencimiento);
    });
    $('#modalmantenimiento').modal('show'); // Abro el modal y muestro toda la data
}

//funcion para eliminar abono
function eliminar(id_prestamo) {
    swal.fire({
        title: 'ELIMINIAR',
        text: "Desea Eliminar el Registro?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Eliminar!'
    }).then((result) => {
        if (result.value) {
            $.post("../../controller/prestamos.php?op=eliminar", { id_prestamo: id_prestamo }, function (data) {
                $('#prestamos_data').DataTable().ajax.reload(); 
                swal.fire('Eliminado!','El registro se elimino correctamente.', 'success')
            });
        }
    })
}

//funcion al darle click al boton nuevo registro
$(document).on("click", "#btnnuevo", function () {
    $('#mdltitulo').html('<h4 class="modal-title center">REGISTRAR NUEVO PRESTAMO</h4>');
    $('#modalmantenimiento').modal('show');
    $('#prestamos_form')[0].reset();
    $('#id_prestamo').val('');
    $('#combo_empresa').val("Seleccione").trigger('change');
    $('#combo_banco').val("Seleccione").trigger('change');
});

init();