<?php
include_once 'presentation.class.php';
include_once 'data_access.class.php';
include_once 'business.class.php';

View::start('Cambio de Especialista','main_html');//Inicializamos página
View::navMain();//Inicializamos menú de navegación

//Obtenemos el id y la especialidad del especialista a borrar
$idborrar = $_POST['idespec'];
$especialidad = $_POST['espec'];

$param= ['idborrar' => $idborrar,
         'especialidad' => $especialidad];
//Consulta para mostrar los especialistas disponibles de la especialidad 
//correspondiente al especialista que se quiere cambiar, sin que éste último
//aparezca
$query = "SELECT idespecialista,nombre, especialidad FROM usuarios JOIN especialistas 
          ON usuarios.id = especialistas.idespecialista WHERE especialidad= :especialidad AND
          especialistas.idespecialista != :idborrar;";

$datos = DB::execute_sql($query,$param)->fetchAll(PDO::FETCH_NAMED); // Se leen todos los datos de una vez

//Cabecera y tabla
echo '<section class="header_class"> <h1> Cambio de especialista </h1> </section>';
echo "<table>";
echo "<tr>";
echo "<th class=\"fila_header\">Especialista</th>";
echo "<th class=\"fila_header\">Especialidad</th>";
echo "<th class=\"fila_header\">Seleccionar</th>";
echo "</tr>";

//Datos y boton con el especialista a borrar y el especialista a asignar
foreach($datos as $registro){
    echo "<tr>";
    echo "<td class=\"fila_data\">{$registro['nombre']}</td>";
    echo "<td class=\"fila_data\">{$registro['especialidad']}</td>";
    echo "<td class=\"fila_data\"><form action='updateespec.php' method=POST>
	                              <input type='submit' value=\"Seleccionar\">
	                              <input type='hidden' name='idborrar' value='$idborrar'>
	                              <input type='hidden' name='idespec'  value='${registro['idespecialista']}'>
	                              </form></td>";
    echo "</tr>";
}
echo '</table>';

View::end();//Finalizamos página
?>