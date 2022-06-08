<?php
  session_start();
    class Conectar{
        protected $dbh;

        protected function Conexion(){
            try{
                $conectar = $this->dbh = new PDO("mysql:local=localhost;dbname=cristal","root","");
                return $conectar;
                
            }catch(Exception $e){
                print "¡Error BD!: " . $e->getMessage() . "<br/>";
                die();
            }
        }
          //para no tener problemas con las tildes o Ñ
        public function set_names(){
			return $this->dbh->query("SET NAMES 'utf8'");
        }

         // ruta principal del proyecto
         public static function ruta(){
            return "http://localhost/prestamos/";
        }

    }
?>