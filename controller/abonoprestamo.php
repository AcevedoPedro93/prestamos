<?php

require_once("../config/conexion.php");
require_once("../modelo/AbonoPrestamo.php");
$usuario = $_SESSION['id_usuario'];
$abonoprestamo = new AbonoPrestamo();

switch ($_GET["op"]) {

    case "listar": //para el datatable
        $datos = $abonoprestamo->get_abonoprestamo();
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["id_abonoprestamo"];
            $sub_array[] = $row["prestamo"];
            $sub_array[] = $row["Num_referencia"];
            $sub_array[] = $row["banco"];
            $sub_array[] = $row["cuenta"];
            $numero = $row["montoPago"];
            $sub_array[] = '$ ' . number_format($numero, 2, '.', ',');
            $numero1 =  $row["nuevosaldo"];
            $sub_array[] = '$ ' . number_format($numero1, 2, '.', ',');
            $fecha = $row["fechaPago"];
            $fechaforma = date('d-m-Y', strtotime($fecha));
            $sub_array[] = $fechaforma;

            //funcion para quitar los ceros de la izquierda y dejar solo el entero
            $str = $row["id_abonoprestamo"];
            $str = ltrim($str, "0");

            $sub_array[] = '<button type="button" onClick="editar(' . $str . ')"  id="' . $str . '" class="btn btn-outline-primary btn-icon"><div><i class="fa fa-edit"></i></div>';
            $sub_array[] = '<button type="button" onClick="eliminar(' . $str . ');"  id="' . $str . '" class="btn btn-outline-danger btn-icon"><div><i class="fa fa-trash"></i></div></button>';

            $data[] = $sub_array;
        }
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        echo json_encode($results);

        break;

    case "filtrar": //para el datatable
        $datos = $abonoprestamo->filtrar_prestamo($_POST['id_prestamo']);
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["id_abonoprestamo"];
            $sub_array[] = $row["prestamo"];
            $sub_array[] = $row["Num_referencia"];
            $sub_array[] = $row["banco"];
            $sub_array[] = $row["cuenta"];
            $numero = $row["montoPago"];
            $sub_array[] = '$ ' . number_format($numero, 2, '.', ',');
            $numero1 =  $row["nuevosaldo"];
            $sub_array[] = '$ ' . number_format($numero1, 2, '.', ',');
            $fecha = $row["fechaPago"];
            $fechaforma = date('d-m-Y', strtotime($fecha));
            $sub_array[] = $fechaforma;

            //funcion para quitar los ceros de la izquierda y dejar solo el entero
            $str = $row["id_abonoprestamo"];
            $str = ltrim($str, "0");

            $sub_array[] = '<button type="button" onClick="editar(' . $str . ')"  id="' . $str . '" class="btn btn-outline-primary btn-icon"><div><i class="fa fa-edit"></i></div>';
            $sub_array[] = '<button type="button" onClick="eliminar(' . $str . ');"  id="' . $str . '" class="btn btn-outline-danger btn-icon"><div><i class="fa fa-trash"></i></div></button>';

            $data[] = $sub_array;
        }
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        echo json_encode($results);

        break;

    case "guardaryeditar":

        $fechaPago = $_POST["fechaPago"];
        $fechadepago = date('Y-m-d H:i:s', strtotime($fechaPago));

        $datos = $abonoprestamo->filtrar_prestamo($_POST["id_abonoprestamo"]); //instancio y llamo el metodo 
        if (empty($_POST["id_abonoprestamo"])) { // si post id_abonoprestamo existe
            $validar = $abonoprestamo->validar_referencia($_POST['referencia']);
            if ($validar) {
                echo 0;
            } else {
                if (is_array($datos) == true and count($datos) == 0) { //verificar si es igaul a 0
                    $abonoprestamo->insert_abonoprestamo(
                        $_POST["id_prestamo"],
                        $_POST["referencia"],
                        $_POST["id_banco"],
                        $_POST["id_cuentaEmpresa"],
                        $_POST['saldoactual'],
                        $_POST["montoPago"],
                        $_POST["nuevoSaldo"],
                        $fechadepago,
                        $_POST["comentario"],
                        $_POST["capital"],
                        $_POST["interes"],
                        $_POST["mora"],
                        $_POST["seguro"],
                        $_POST["iva"],
                        $usuario
                    );
                    $abonoprestamo->update_saldo(
                        $_POST["id_prestamo"],
                        $_POST["nuevoSaldo"]
                    );
                    echo 1;
                }
            }
        } else {
            $abonoprestamo->update_abonoprestamo(
                $_POST["id_abonoprestamo"],
                $_POST["id_prestamo"],
                $_POST["referencia"],
                $_POST["id_banco"],
                $_POST["id_cuentaEmpresa"],
                $_POST['saldoactual'],
                $_POST["montoPago"],
                $_POST['nuevoSaldo'],
                $fechadepago,
                $_POST["comentario"],
                $_POST["capital"],
                $_POST["interes"],
                $_POST["mora"],
                $_POST["seguro"],
                $_POST["iva"],
                $usuario
            );
            $abonoprestamo->update_saldo(
                $_POST["id_prestamo"],
                $_POST["nuevoSaldo"]
            );
            echo 2;
        }
        break;

    case "mostrar": //mostrar datos al editar

        $datos = $abonoprestamo->get_abonoprestamo_x_id($_POST["id_abonoprestamo"]);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["id_abonoprestamo"] = $row["id_abonoprestamo"];
                //funcion para quitar los ceros de la izquierda y dejar solo el entero
                $str = $row["id_abonoprestamo"];
                $output['id_abform'] = ltrim($str, "0");

                $output["id_prestamo"] = $row["id_prestamo"];
                $output["Num_referencia"] = $row["Num_referencia"];
                $output["id_banco"] = $row["id_banco"];
                $output["id_cuentaEmpresa"] = $row["id_cuentaEmpresa"];
                $output["saldoactual"] = $row["saldoactual"];
                $output["montoPago"] = $row["montoPago"];
                $output["nuevosaldo"] = $row["nuevosaldo"];
                $fechapago   = $row["fechaPago"];
                $fechaforma = date('d-m-Y', strtotime($fechapago));
                $output["fechaPago"] =  $fechaforma;
                $output["comentario"] = $row["comentario"];
                $output["capital"] = $row["capital"];
                $output["interes"] = $row["intereses"];
                $output["mora"] = $row["cantMora"];
                $output["seguro"] = $row["cantSeguro"];
                $output["iva"] = $row["cant_iva"];
            }
            echo json_encode($output, JSON_FORCE_OBJECT);
        }
        break;

    case "eliminar":
        $abonoprestamo->delete_abonoprestamo($_POST["id_abonoprestamo"], $usuario);
        break;

    case "combo":
        $datos = $prestamo->get_prestamo(); //creo variable y le asigno el metodo
        if (is_array($datos) == true and count($datos) > 0) { //verifico si los datos que vienen es un array y es mayor a 0
            $html = "<option> Seleccione </option>";
            foreach ($datos as $row) {
                $html .= "<option value='" . $row['id_prestamo'] . "'>" . $row['Numprestamo'] . "</option>";
            }
            echo $html;
        }

        break;
}
