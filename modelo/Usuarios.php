<?php
    class Usuarios extends Conectar{
        
        //funcion para inicar session
        public function login(){
            $conectar= parent::conexion();
            parent::set_names();
            //si el post enviar no esta vacio
            if(isset($_POST['enviar'])){
                     $usuario      = $_POST['usuario'];
                     $contrasena = $_POST['password'];
                     //validar si el correo y la contrasenha estan vacios
                     if(empty($usuario) and empty($contrasena)){
                           //si viene vacios lo redirecciono a la ruta principal y capturo el mensaje 2, y salir de ejecutar
                          header("Location:" .Conectar::ruta()."index.php?m=2");
                          exit();
                     }else{
                         $sql = "SELECT * FROM usuarios WHERE nombreusuario = ? and password = ? and estadoUser = 001 and estadoReg = 1";
                         $stmt =$conectar->prepare($sql);
                         $stmt->bindValue(1, $usuario);
                         $stmt->bindValue(2, $contrasena);
                         $stmt->execute();
                         $resultado =   $stmt->fetch();
                         if(is_array($resultado) and count($resultado)>0){
                                    $_SESSION['id_usuario'] = $resultado['id_usuario'];
                                    $_SESSION['id_empleado'] = $resultado['id_empleado'];
                                    $_SESSION['nombreusuario'] = $resultado['nombreusuario'];
                                    $_SESSION['id_rol'] = $resultado['id_rol'];
                                    header("Location:" .Conectar::ruta()."vista/Home/");
                                    exit();
                         }else{
                             //si no coincide user y contrasenha la condicion lo redirecciono y capturo mensaje 1
                            header("Location:" .Conectar::ruta()."index.php?m=1");
                            exit();
                         }      
                     }
            }

        }
    }
?>