<?php
include_once 'presentation.class.php';
include_once 'data_access.class.php';
include_once 'business.class.php';

View::start('Gestionar Especialidades','main_html');//Inicializamos página
View::navMain();//Inicializamos menú de navegación

//Consulta para obtener los datos de los usuarios declarados como especialistas
$query = "SELECT  idespecialista, nombre, especialidad FROM
          usuarios JOIN especialistas ON usuarios.id = especialistas.idespecialista;";
$datos = DB::execute_sql($query)->fetchAll(PDO::FETCH_NAMED);// Se leen todos los datos de una vez

//Creamos seccion header y las cabeceras de la tabla a mostrar
echo '<section class="header_class"> <h1> Gestionar Especialidades </h1> </section>';
echo "<table>";
echo "<tr>";
echo "<th class=\"fila_header\">Nombre</th>";
echo "<th class=\"fila_header\">Especialidad</th>";
echo "<th class=\"fila_header\">Editar Especialidad</th>";
echo "<th class=\"fila_header\">Eliminar Especialidad</th>";
echo "</tr>";

//Rellenamos la tabla a mostrar con los datos obtenidos y añadimos dos botones
//a los que les pasamos las ids de los especialistas.
foreach($datos as $registro){
    echo "<tr>";
    echo "<td class=\"fila_data\">{$registro['nombre']}</td>";
    echo "<td class=\"fila_data\">{$registro['especialidad']}</td>";
	echo "<td class=\"fila_data\"><form action='modify_espec.php' method=POST>
	                              <input type='submit' value=\"Editar Especialidad\">
	                              <input type='hidden' name='id' value='${registro['idespecialista']}'>
	                              <input type='hidden' name='espec' value='${registro['especialidad']}'>
	                              </form></td>";
	echo "<td class=\"fila_data\"><form action='remove_espec.php' method=POST>
	                              <input type='submit' value=\"Borrar Especialidad\">
	                              <input type='hidden' name='id' value='${registro['idespecialista']}'>
	                              <input type='hidden' name='espec' value='${registro['especialidad']}'>
	                              </form></td>";
    echo "</tr>";
}
echo '</table>';
echo "<td><a href='add_espec.php'><button type='button'>Añadir Especialidad</button></a></td>";
View::end();//Finalizamos página
?>