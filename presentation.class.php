<?php
include_once 'business.class.php';
class View{
    
/*------------------------Funcion inicializadora paginas----------------------*/    
    public static function  start($title,$class){
        $html = "<!DOCTYPE html>
                <html class=\"$class\" lang=\"es\">
                <head>
                <meta charset=\"utf-8\">
                <link rel=\"stylesheet\" type=\"text/css\" href=\"estilos.css\">
                <script src=\"scripts.js\"></script>
                <title>$title</title>
                </head>
                <main>\n";
        User::session_start();
        echo $html;
    }
    
/*------------------------------Funciones Navegacion--------------------------*/  
    /*Para index.php*/
    public static function navMain(){
        $user = User:: getLoggedUser();
        if($user != null) {
            $name = $user['nombre'];
            $navIni = "<nav class=\"nav_class1\">
                       <a href=\"index.php\"> Inicio </a>";
                       
            switch($user['tipo']) {
                case 1: 
                        /*----------------------Administrador-----------------*/
                       $navMed= "<a href=\"managespec.php\"> Gestionar especialidades </a>";
                       break;
                case 2:
                        /*--------------------Especialista--------------------*/
                        $navMed= "<a href=\"showpatient.php\"> Ver mis pacientes</a>";
                        break;
                case 3:
                        /*----------------------Auxiliar----------------------*/
                        $navMed= "<a href=\"addhist.php\"> Modificar historial </a>";
                        break;
                case 4:
                        /*----------------------Paciente----------------------*/
                        $navMed= "<a href=\"showespecialists.php\"> Ver mis especialistas </a>
                                  <a href=\"medichist.php\"> Ver mi historial médico </a>
                                  <a href=\"selectespec.php\"> Seleccionar especialista </a>";
                        break;
            }
            
            $navFin = " <a href=\"logout.php\"> Cerrar Sesión</a>
                        <p id=\"usernametag\"> Bienvenido/a, $name </p> 
                        </nav>\n";
            echo $navIni.$navMed.$navFin;
        }else {
            $navIni= "<nav class=\"nav_class1\">
                  <a href=\"login.php\"> Iniciar Sesión</a>
                  </nav>\n"; 
            echo $navIni;
        }
    }
    
    
    /*Para login.php */
    public static function navPagSecun(){
        $navIni= "<nav class=\"nav_class1\">
                  <a href=\"index.php\"> Inicio </a>
                  </nav>\n";
        echo $navIni;
    }
    
    
/*--------------------Funciones para footer/final de pagina-------------------*/    
    public static function footer() {
        $footer="<div id=\"footer_index_div\">
                    <footer id=\"footer_index\"> 
                        <p>
                            C/Mesa y López nº 26, 35010, Las Palmas de Gran Canaria, España.
                            All Rights Reserved. WebSalud, 2021.
                        </p>
                    </footer>
                </div>";
        echo $footer;
    }
    
    public static function end(){
        echo '</main>
              </html>';
    }
}


    