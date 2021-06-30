<?php
include_once 'presentation.class.php';
include_once 'data_access.class.php';
include_once 'business.class.php';

View::start('Mis Especialistas','main_html');//Inicializamos página
View::navMain();//Inicializamos menú de navegación

//Obtenemos id de usuario logueado
$user = User::getLoggedUser();
$id = $user['id'];

//Consulta para obtener aquellos especialistas NO relacionados con el usuario
//logueado y cuya especialidad NO este ya adscrita a un especialista
//relacionado con el usuario logueado (1 especialista por paciente en una especialidad)
$param = ['id' => $id];


$query = "SELECT idespecialista, nombre, especialidad FROM usuarios JOIN especialistas 
          ON usuarios.id = especialistas.idespecialista  WHERE usuarios.tipo = 2 AND
          idespecialista NOT IN 
          (SELECT idespecialista FROM pacientesespecialistas 
           WHERE pacientesespecialistas.idpaciente = :id) AND
           especialidad NOT IN
           (SELECT especialidad FROM especialistas JOIN pacientesespecialistas
            ON especialistas.idespecialista = pacientesespecialistas.idespecialista
            WHERE pacientesespecialistas.idpaciente = :id) AND
            especialidad NOT IN 
            (SELECT especialidad FROM especialistas WHERE especialidad = \"\");";

$datos = DB::execute_sql($query,$param)->fetchAll(PDO::FETCH_NAMED);// Se leen todos los datos de una vez

//Sección de cabecera y tabla
echo '<section class="header_class"> <h1> Mis Especialistas </h1> </section>';
echo "<table>";
echo "<tr>";
echo "<th class=\"fila_header\">Especialista</th>";
echo "<th class=\"fila_header\">Especialidad</th>";
echo "<th class=\"fila_header\">ID especialista</th>";
echo "<th class=\"fila_header\">Seleccionar</th>";
echo "</tr>";

//Se rellena la tabla con boton para poder seleccionar especialista
foreach($datos as $registro){
    echo "<tr>";
    echo "<td class=\"fila_data\">{$registro['nombre']}</td>";
    echo "<td class=\"fila_data\">{$registro['especialidad']}</td>";
    echo "<td class=\"fila_data\">{$registro['idespecialista']}</td>";
    echo "<td class=\"fila_data\"><form action='selectespecupdate.php' method=POST>
	                              <input type='submit' value=\"Seleccionar\">
	                              <input type='hidden' name='idespec' value='${registro['idespecialista']}'>
	                              </form></td>";
    echo "</tr>";
}
echo '</table>';

View::end();//Finalizamos página
?>