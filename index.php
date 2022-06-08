<?php
require_once("config/conexion.php");
if(isset($_POST['enviar']) and $_POST['enviar'] == "si"){
    require_once("modelo/Usuarios.php");
    $usuario = new Usuarios();
    $usuario->login();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar Session</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="public/plugins/fontawesome-free/css/all.min.css">

    <link rel="stylesheet" href="public/plugins/icheck-bootstrap/icheck-bootstrap.min.css">

    <link rel="stylesheet" href="public/css/adminlte.min.css?v=3.2.0">

    <script nonce="d9391252-7cfb-4d09-9ad2-79e5d4c590ad">
        (function(w, d) {
            ! function(a, e, t, r) {
                a.zarazData = a.zarazData || {}, a.zarazData.executed = [], a.zaraz = {
                    deferred: []
                }, a.zaraz.q = [], a.zaraz._f = function(e) {
                    return function() {
                        var t = Array.prototype.slice.call(arguments);
                        a.zaraz.q.push({
                            m: e,
                            a: t
                        })
                    }
                };
                for (const e of ["track", "set", "ecommerce", "debug"]) a.zaraz[e] = a.zaraz._f(e);
                a.addEventListener("DOMContentLoaded", (() => {
                    var t = e.getElementsByTagName(r)[0],
                        z = e.createElement(r),
                        n = e.getElementsByTagName("title")[0];
                    for (n && (a.zarazData.t = e.getElementsByTagName("title")[0].text), a.zarazData.w = a.screen.width, a.zarazData.h = a.screen.height, a.zarazData.j = a.innerHeight, a.zarazData.e = a.innerWidth, a.zarazData.l = a.location.href, a.zarazData.r = e.referrer, a.zarazData.k = a.screen.colorDepth, a.zarazData.n = e.characterSet, a.zarazData.o = (new Date).getTimezoneOffset(), a.zarazData.q = []; a.zaraz.q.length;) {
                        const e = a.zaraz.q.shift();
                        a.zarazData.q.push(e)
                    }
                    z.defer = !0, z.referrerPolicy = "origin", z.src = "/cdn-cgi/zaraz/s.js?z=" + btoa(encodeURIComponent(JSON.stringify(a.zarazData))), t.parentNode.insertBefore(z, t)
                }))
            }(w, d, 0, "script");
        })(window, document);
    </script>
</head>

<body class="hold-transition login-page">
    <div class="login-box">

        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                 <?php
                   if(isset($_GET["m"])){
                       switch($_GET["m"]){
                           case 1:
                            ?>
                              <div class="alert alert-warning" role="alert">
                                    Error, datos incorrectos
                                </div>
                         <?php
                         break;
                            case 2:
                                ?>
                                 <div class="alert alert-warning" role="alert">
                                    Error, campos vacios
                                </div>
                            <?php
                            break;
                       }
                   }
                 ?>
               
                <a href="../../index2.html" class="h1"><b>LOGIN</b>LTE</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg"> Llena los campos para iniciar session</p>
                <form action="" method="post">
                    <div class="input-group mb-3">
                        <input type="text" name="usuario" id="usuario"class="form-control" placeholder="Usuario">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" id="password"class="form-control" placeholder="Contraseña">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Recordarme
                                </label>
                            </div>
                        </div>

                        <div class="col-6">
                             <input type="hidden" name="enviar" value="si">
                            <button type="submit" class="btn btn-primary btn-block">Iniciar Session</button>
                        </div>

                    </div>
                </form>
                <div class="social-auth-links text-center mt-2 mb-3">
                    <a href="#" class="btn btn-block btn-primary">
                        <i class="fab fa-facebook mr-2"></i> Inicia usando Facebook
                    </a>
                    <a href="#" class="btn btn-block btn-danger">
                        <i class="fab fa-google-plus mr-2"></i> Inicia usando Google+
                    </a>
                </div>

            </div>

        </div>

    </div>


    <script src="public/plugins/jquery/jquery.min.js"></script>

    <script src="public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="public/js/adminlte.js"></script>
</body>

</html>