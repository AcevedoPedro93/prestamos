<?php
require_once("../config/conexion.php");
require_once("../modelo/Prestamos.php");
$usuario = $_SESSION['id_usuario'];
$prestamo = new Prestamo();

switch ($_GET["op"]) {

    case "listar":
        $datos = $prestamo->get_prestamo();
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();

            $sub_array[] = $row["id_prestamo"];
            $sub_array[] = $row["empresa"];
            $sub_array[] = $row["banco"];
            $sub_array[] = $row["Numprestamo"];
            //funcion para dar formato a un numero con sus decimales, y separador de miles
            $numero =  $row["montototal"];
            $sub_array[] = '$ ' . number_format($numero, 2, '.', ',');
            $numero2 = $row["saldoActual"];
            $sub_array[] = '$ ' . number_format($numero2, 2, '.', ',');

            //Formateando fecha 
            $fecha = $row["fechaOtorgamiento"];
            $fechaforma = date('d-m-Y', strtotime($fecha));
            $sub_array[] = $fechaforma;

            //funcion para quitar los ceros de la izquierda y dejar solo el entero
            $str = $row["id_prestamo"];
            $str = ltrim($str, "0");

            $sub_array[] = '<button type="button" onClick="editar('.$str.');"  id='.$str.' class="btn btn-outline-primary btn-icon" title="Editar"><div><i class="fa fa-edit"></i></div></button>';
            $sub_array[] = '<button type="button" onClick="eliminar('.$str.');"  id='.$str.' class="btn btn-outline-danger btn-icon" title="Eliminar"><div><i class="fa fa-trash"></i></div></button>';
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

        $fechaotor = $_POST["FechaOtorgamiento"];
        $fechaformaotor = date('Y-m-d H:i:s', strtotime($fechaotor));
        $fechavence = $_POST["fechaVencimiento"];
        $fechaformavence = date('Y-m-d H:i:s', strtotime($fechavence));
    
        $datos = $prestamo->get_prestamo_x_id($_POST["id_prestamo"]); //instancio y llamo el metodo 
        if (empty($_POST["id_prestamo"])) { // si post esta vacio o no existe
            $validar = $prestamo->validar_prestamo($_POST["NumPrestamo"]);
            if ($validar) {
                echo 0;
            } else {
                if (is_array($datos) == true and count($datos) == 0) {   //verificar si es array y si es igaul a 0
                    $prestamo->insert_prestamo(
                        $_POST["id_empresa"],
                        $_POST["id_banco"],
                        $_POST["NumPrestamo"],
                        $_POST["montototal"],
                        $_POST["SaldoActual"],
                        $_POST["tasa"],
                        $_POST["PagoMensual"],
                        $fechaformaotor,
                        $fechaformavence,
                        $usuario
                    );
                }
                echo 1;
            }
        } else {
            $prestamo->update_prestamo(
                $_POST["id_prestamo"],
                $_POST["id_empresa"],
                $_POST["id_banco"],
                $_POST["NumPrestamo"],
                $_POST["montototal"],
                $_POST["SaldoActual"],
                $_POST["tasa"],
                $_POST["PagoMensual"],
                $fechaformaotor,
                $fechaformavence,
                $usuario
            );
            echo 2;
        }
        break;
    case "mostrar":

        $datos = $prestamo->get_prestamo_x_id($_POST["id_prestamo"]);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["id_prestamo"] = $row["id_prestamo"];
                //function para quitar ceros a la izquierda
                $str = $row["id_prestamo"];
                $output["cod_prestamo"]= ltrim($str, "0");

                $output["id_empresa"] = $row["id_empresa"];
                $output["id_banco"] = $row["id_banco"];
                $output["NumPrestamo"] = $row["NumPrestamo"];
                $output["montototal"] = $row["montototal"];
                $output["SaldoActual"] = $row["SaldoActual"];
                $output["tasa"] = $row["tasa"];
                $output["PagoMensual"] = $row["PagoMensual"];

                $fecha   = $row["FechaOtorgamiento"];
                $fechaforma = date('d-m-Y', strtotime($fecha));
                $output["FechaOtorgamiento"] =  $fechaforma;

                $fecha2 = $row["fechaVencimiento"];
                $fechaforma2 = date('d-m-Y', strtotime($fecha2));
                $output["fechaVencimiento"] = $fechaforma2;
            }
            echo json_encode($output, JSON_FORCE_OBJECT);
        }

        break;

    case "eliminar":
        $prestamo->delete_prestamo($_POST["id_prestamo"], $usuario);
        break;

    case "calcular":

        $datos = $prestamo->get_prestamo_x_id($_POST["id_prestamo"]);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["NumPrestamo"] = $row["NumPrestamo"];
                $output["montototal"] = $row["montototal"];
                $output["SaldoActual"] = $row["SaldoActual"];
                $output["PagoMensual"] = $row["PagoMensual"];
            }

            echo json_encode($output, JSON_FORCE_OBJECT);
        }
        break;

    case "combo":

        $datos = $prestamo->get_prestamo(); //creo variable y le asigno el metodo
        if (is_array($datos) == true and count($datos) > 0) { //verifico si los datos que vienen es un array y es mayor a 0
            $html = "<option> Seleccione </option>";
            foreach ($datos as $row) {
                
                $html .= "<option value='" . $row['id_prestamo'] . "'>" . $row['Numprestamo'] . " / " . $row['banco'] . "</option>";
            }
            echo $html;
        }

        break;
}
