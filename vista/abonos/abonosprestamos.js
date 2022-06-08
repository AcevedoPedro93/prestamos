var tabla;

function init() {
    $("#abonosprestamos_form").on("submit", function (e) {
        guardaryeditar(e);
    });
}

$(document).ready(function () {

    $.post("../../controller/empresa.php?op=combo", function (data, status) {
        // console.log(data);
        $('#combo_empresa').html(data);
    });

    $.post("../../controller/banco.php?op=combo", function (data, status) {
        // console.log(data);
        $('#combo_banco').html(data);
    });

    $.post("../../controller/prestamos.php?op=combo", function (data, status) {
        // console.log(data);
        $('#id_prestamo').html(data);
    });

    $.post("../../controller/prestamos.php?op=combo", function (data, status) {
        // console.log(data);
        $('#combo_prestamo').html(data);
    });

    //llenar combos
    $('#combo_banco').change(function () {
        $("#combo_banco option:selected").each(function () {
            id_banco = $(this).val();
            id_cuenta = $('#id_cuenta').val();
            //   console.log(id_banco + id_cuenta);
            $.post("../../controller/cuentas.php?op=combo", { id_banco: id_banco, id_cuenta: id_cuenta }, function (data, status) {
                $('#combo_cuenta').html(data);
            });

        });

    });

});

function cargarDataTable() {
    let date = new Date();
    let fechactual = String(date.getDate()).padStart(2, '0') + '' + String(date.getMonth() + 1).padStart(2, '0') + '' + date.getFullYear();
    let selectedOption = $('#combo_prestamo').find(":selected").val();
    let selectprestamo = $('#combo_prestamo').find(":selected").text();
    tabla = $('#AbonosPrestamos_data').dataTable({
        "buttons": [
            {
                extend: 'excel',
                text: '<i class="fa fa-download"></i> Excel ',
                title: 'Abonos '+ selectprestamo + fechactual,
                exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }
            },

            {
                extend: 'pdf',
                text: '<i class="fa fa-download"></i> PDF',
                title: 'Abonos '+ selectprestamo + fechactual,
                exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }
            },
            {
                extend: 'csv',
                text: '<i class="fa fa-clipboard"></i> CSV',
                title: 'Abonos '+ selectprestamo + fechactual,
                exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }
            },
            {
                extend: 'print',
                text: '<i class="fa fa-print"></i> Imprimir',
                title: 'Abonos '+ selectprestamo + fechactual,
                exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }
            },
        ],
        dom: 'Bfrtip',//Definimos los elementos del control de tabla
        "ajax": {//ajax para traer los datos desde el controller y paso el parametro del prestamo seleccionado
            url: "../../controller/abonoprestamo.php?op=filtrar",
            data: { 'id_prestamo': selectedOption },
            type: "post",
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
        "footerCallback": function (row, data, start, end, display) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
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

            // Total de pagina de pagina actual
            pageTotal = api
                .column(5, { page: 'current' })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            // Update footer
            $(api.column(5).footer()).html(
                ' Tot. abonos filtro: $ ' + pageTotal.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') + ' ( Total Abonos : $' + total.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') + ')'
            );
        }
    }).DataTable();
}

//funcion guardar y editar abonos
function guardaryeditar(e) {
    e.preventDefault();
    var formData = new FormData($("#abonosprestamos_form")[0]);

    $.ajax({
        url: "../../controller/abonoprestamo.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            if (datos == 0) {
                swal.fire('Advertencia', 'El número de referencia ya existe.', 'warning')// segun la respuesta muestro mensaje
            } else if (datos == 1){
                $('#abonosprestamos_form')[0].reset(); // reseteo el modal 
                $('#AbonosPrestamos_data').DataTable().ajax.reload();// recargo tabla
                $('#combo_banco').val("Seleccione").trigger('change'); //lo dejo en seleccione
                $('#id_prestamo').val("Seleccione").trigger('change');// lo dejo en seleccione
                $('#id_abonoprestamo').val('');//limpio campo
                swal.fire('Registro!', 'Abono guardado correctamente.', 'success')//muestro mensaje
            }else{
                $('#abonosprestamos_form')[0].reset(); // reseteo el modal 
                $('#AbonosPrestamos_data').DataTable().ajax.reload();// recargo tabla
                $('#modalAbonosPrestamo').modal('hide');// cierro el modal
                swal.fire('Registro!', 'Abono actualizado correctamente.', 'success')//muestro mensaje
            }
        }
    });
}

//funcion para mostrar los datos en el modal segun abono seleccionado
function editar(id_abonoprestamo) {
    $('#id_prestamo').removeAttr('onchange');//quito la funcion que tiene al hacer un cambio 
    $('#mdltitulo').html('EDITAR ABONO A PRESTAMO');// camboo titulo

    $.post("../../controller/abonoprestamo.php?op=mostrar", { id_abonoprestamo: id_abonoprestamo }, function (data) {
        data = JSON.parse(data);
        $('#id_abonoprestamo').val(data.id_abform);//id sin ceros a la izquierda
        $('#cod_abonoPrestamo').val(data.id_abonoprestamo);//para rellenar el combo y hacer el cambio
        $('#id_prestamo').val(data.id_prestamo).trigger('change');//igual que el anterior
        $('#referencia').val(data.Num_referencia);
        $('#combo_banco').val(data.id_banco).trigger('change');//igual que el anterior
        $('#combo_cuenta').val(data.id_cuentaEmpresa).trigger('change');//igual que el anterior
        $('#id_cuenta').val(data.id_cuentaEmpresa);
        $('#saldoactual').val(data.saldoactual);
        $('#montoPago').val(data.montoPago);
        $('#nuevoSaldo').val(data.nuevosaldo);
        $('#fechaPago').val(data.fechaPago);
        $('#comentario').val(data.comentario);
        $('#capital').val(data.capital);
        $('#interes').val(data.interes);
        $('#mora').val(data.mora);
        $('#seguro').val(data.seguro);
        $('#iva').val(data.iva);
    });
    selectBancoCuenta();
    $('#modalAbonosPrestamo').modal('show');
}

//funcion para eliminar abono
function eliminar(id_abonoprestamo) {
    //pregunta confirmacion
    swal.fire({
        title: '¿ESTA SEGURO?',
        text: "Seguro deseas Eliminar el Registro?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Eliminar!'
    }).then((result) => {
        if (result.value) {
            $.post("../../controller/abonoprestamo.php?op=eliminar", { id_abonoprestamo: id_abonoprestamo }, function (data) {
                $('#AbonosPrestamos_data').DataTable().ajax.reload(); // recargo tabla
                swal.fire('Eliminado!', 'El registro se elimino correctamente.', 'success') //muestro mensaje
            });
        }
    })
}
//funcion al darle click al boton nuevo registro
$(document).on("click", "#btnnuevoabono", function () {
    $('#id_prestamo')[0].setAttribute("onchange", "montopago()"); //le agrego la funcion montopago 
    $('#mdltitulo').html('<h4 class="modal-title">REGISTRAR NUEVO ABONO</h4>');//cambio el titulo
    $('#modalAbonosPrestamo').modal('show');// abro el modal
    $('#abonosprestamos_form')[0].reset();// reseteo el formulario por si tenia datos de editar
    $('#id_abonoprestamo').val('');//limpio campo
    $('#cod_abonoPrestamo').prop('readonly', true);// agrego readonly
    $('#combo_banco').val("Seleccione").trigger('change'); //lo dejo en seleccione
    $('#id_prestamo').val("Seleccione").trigger('change');// lo dejo en seleccione
});

init();

//CAMBOS BANCOS Y CUENTA
//Retrazo la ejecucion de la funcion para que al momento de ejcutarla el input id_cuenta ya tenga el valor de la cuenta que trae la funcion para mostrar datos
const selectBancoCuenta = function () {
    setTimeout(function () {
        $("#combo_banco option:selected").each(function () {
            id_banco = $(this).val();
            id_cuenta = $('#id_cuenta').val();
            $.post("../../controller/cuentas.php?op=combo", { id_banco: id_banco, id_cuenta: id_cuenta }, function (data, status) {
                $('#combo_cuenta').html(data);
            });
        });
    }, 200);
}
//cargar saldoactual y pago mensual que viene del controller en la opcion calcular
function montopago() {
    prestamo = $('#id_prestamo').val();
    $.post("../../controller/prestamos.php?op=calcular", { id_prestamo: prestamo }, function (data) {
        data = JSON.parse(data);
        $('#saldoactual').val(data.SaldoActual);
        $('#montoPago').val(data.PagoMensual);

        saldoActual = $('#saldoactual').val();
        montoPago = $('#montoPago').val();

        if (montoPago != '') {
            const newSaldo = (parseFloat(saldoActual - montoPago));
            $('#nuevoSaldo').val(parseFloat(newSaldo).toFixed(4));
        }

    });
}

function closemodal() {
    $('#abonosprestamos_form')[0].reset();
}

function nuevosaldo() {
    saldoActual = $('#saldoactual').val();
    montoPago = $('#montoPago').val();

    if (montoPago != '') {
        const newSaldo = (parseFloat(saldoActual - montoPago));
        $('#nuevoSaldo').val(parseFloat(newSaldo).toFixed(4));
    }
}




