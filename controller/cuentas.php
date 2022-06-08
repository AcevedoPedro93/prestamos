<?php
    require_once("../config/conexion.php");
    require_once("../modelo/Cuenta.php");

    $cuentas = new Cuenta();
    switch($_GET["op"]){
 
        case "combo":
            $datos = $cuentas->get_cuenta($_POST["id_banco"]);//creo variable y le asigno el metodo
             if(is_array($datos)==true and count($datos)>0){//verifico si los datos que vienen es un array y es mayor a 0
               $html = "<option> Seleccione </option>"; 
                    foreach($datos as $row)
                    {
                        if($row['id_cuentaEmpresa']==$_POST["id_cuenta"]){
                            $html.= "<option value=' ".$row['id_cuentaEmpresa']." '  selected>".$row['numeroCuenta']." | ".$row['titularCuenta']."</option>";
                       }else{
                           $html.= "<option value='".$row['id_cuentaEmpresa']."'>".$row['numeroCuenta']." | ".$row['titularCuenta']."</option>";
                       }
                        
                    }
                    echo $html;
             }
            break; 
            case "combo2":
                $datos = $cuentas->get_cuenta($_POST["id_banco"]);//creo variable y le asigno el metodo
                 if(is_array($datos)==true and count($datos)>0){//verifico si los datos que vienen es un array y es mayor a 0
                   $html = "<option> Seleccione </option>"; 
                        foreach($datos as $row)
                        {              
                               $html.= "<option value='".$row['id_cuentaEmpresa']."'>".$row['numeroCuenta']." | ".$row['titularCuenta']."</option>";               
                        }
                        echo $html;
                 }
                break; 
    }
?>