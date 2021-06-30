<?php
include_once 'presentation.class.php';
include_once 'data_access.class.php';
include_once 'business.class.php';

View::start('Mis Especialistas','main_html');//Inicializamos página
View::navMain();//Inicializamos menú de navegación

//Obtenemos id de usuario logueado
$user = User::getLoggedUser();
$id = $user['id'];

//Consulta para obtener los especialistas relacionados con el usuario logueado
$param = ['id' => $id];
$query = "SELECT idespecialista, nombre, especialidad FROM usuarios JOIN especialistas 
          ON usuarios.id = especialistas.idespecialista WHERE usuarios.tipo = 2
          AND usuarios.id IN
          (SELECT idespecialista from pacientesespecialistas 
           WHERE pacientesespecialistas.idpaciente = :id);";

$datos = DB::execute_sql($query,$param)->fetchAll(PDO::FETCH_NAMED); // Se leen todos los datos de una vez

//Sección de cabecera y tabla
echo '<section class="header_class"> <h1> Mis Especialistas </h1> </section>';
echo "<table>";
echo "<tr>";
echo "<th class=\"fila_header\">Especialista</th>";
echo "<th class=\"fila_header\">Especialidad</th>";
echo "<th class=\"fila_header\">Cambiar</th>";
echo "<th class=\"fila_header\">Borrar</th>";
echo "</tr>";

//Se rellena la tabla con boton al que se le pasa id y especialidad del especialista
// a cambiar
$idfila = 0;
foreach($datos as $registro){
    echo "<tr id=\"$idfila\">";
    echo "<td class=\"fila_data\">{$registro['nombre']}</td>";
    echo "<td class=\"fila_data\">{$registro['especialidad']}</td>";
    echo "<td class=\"fila_data\"><form action='changeespec.php' method=POST>
	                              <input type='submit' value=\"Cambiar\">
	                              <input type='hidden' name='idespec' value='${registro['idespecialista']}'>
	                              <input type='hidden' name='espec' value='${registro['especialidad']}'>
	                              </form></td>";
	echo "<td class=\"fila_data\"><button onclick=\"deleteEspecialist($idfila,${registro['idespecialista']}, $id)\"> Borrar</button></td>";                              
    echo "</tr>";
    $idfila++;
}
echo '</table>';
View::end();//Finalizamos página
?>