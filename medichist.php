<?php
include_once 'presentation.class.php';
include_once 'data_access.class.php';
include_once 'business.class.php';

View::start('Mi Historial Médico','main_html');//Inicializamos página
View::navMain();//Inicializamos menú de navegación

//Dependiendo de si se es especialista o el propio paciente, cogemos la id 
//de referencia del id pasado o usuario logueado, respectivamente
if(isset($_POST['id'])) {
    $id = $_POST['id'];
} else {
    $user = User::getLoggedUser();
    $id = $user['id'];
}

//Consulta, evitando inyeccion SQL para obtener campos del historial 
//relacionados con la id usuario escogido anteriormente
$param = ['id' => $id];
$query = "SELECT fechahora, asunto, descripcion, idcreador 
          FROM historial JOIN usuarios on historial.idpaciente = usuarios.id 
          WHERE usuarios.id = :id ORDER BY fechahora DESC;";
          
$datos = DB::execute_sql($query,$param)->fetchAll(PDO::FETCH_NAMED); // Se leen todos los datos de una vez

//Sección de cabecera y tabla
echo '<section class="header_class"> <h1> Mi historial médico </h1> </section>';
echo "<table>";
echo "<tr>";
echo "<th class=\"fila_header\">Fecha</th>";
echo "<th class=\"fila_header\">Asunto</th>";
echo "<th class=\"fila_header\">Descripción</th>";
echo "<th class=\"fila_header\">ID del creador</th>";
echo "</tr>";

//Se rellena la tabla
foreach($datos as $registro){
    $fyhsinmod = $registro['fechahora'];
    $fyhconmod = date("d-m-Y H:i:s", $fyhsinmod);//Fecha en modo DD-MM-YYY Hh:mm AM/PM
    echo "<tr>";
    echo "<td class=\"fila_data\"> $fyhconmod</td>";
    echo "<td class=\"fila_data\">{$registro['asunto']}</td>";
    echo "<td class=\"fila_data\">{$registro['descripcion']}</td>";
    echo "<td class=\"fila_data\">{$registro['idcreador']}</td>";
    echo "</tr>";
}
echo '</table>';

View::end();//Finalizamos página
?>
