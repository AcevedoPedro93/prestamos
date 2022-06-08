<?php
    require_once("../config/conexion.php");
    require_once("../modelo/Empresa.php");
    $empresa = new Empresa();

    switch($_GET["op"]){

        case "combo":
            $datos = $empresa->get_empresa();//creo variable y le asigno el metodo
             if(is_array($datos)==true and count($datos)>0){//verifico si los datos que vienen es un array y es mayor a 0
                    $html = "<option> Seleccione </option>"; 
                    foreach($datos as $row)
                    {
                        $html.= "<option value='".$row['id_empresa']."'>".$row['nombre']."</option>";
                    }
                    echo $html;
             }
            break; 

     

    }
?>