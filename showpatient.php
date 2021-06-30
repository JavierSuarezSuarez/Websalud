<?php
include_once 'presentation.class.php';
include_once 'data_access.class.php';
include_once 'business.class.php';

View::start('Mis Pacientes','main_html');//Inicializamos página
View::navMain();//Inicializamos menú de navegación

//Recogemos id y tipo de usuario (especialista) logueado
$user = User::getLoggedUser();
$id = $user['id']; 
$tipo = $user['tipo'];

$param = ['id' => $id];
//Si se ha filtrado la búsqueda
if(isset($_POST['search']) and $_POST['search'] != "") {
    $busqueda = htmlentities($_POST['search']);
    $param = ['id' => $id,
              'busqueda' => $busqueda];
    //Buscamos los datos de los pacientes con nombre dado en la búsqueda
    //que estén asignados al especialista logueado
    $query = "SELECT id, cuenta, nombre FROM usuarios WHERE usuarios.tipo = 4 AND nombre LIKE :busqueda
          AND usuarios.id IN
          (SELECT idpaciente from pacientesespecialistas 
          WHERE pacientesespecialistas.idespecialista = :id);";
    $datos = DB::execute_sql($query,$param)->fetchAll(PDO::FETCH_NAMED);// Se leen todos los datos de una vez
} else {
    //Buscamos los datos de los pacientes que estén asignados al especialista logueado
    $param = ['id' => $id];
    $query = "SELECT id, cuenta, nombre FROM usuarios WHERE usuarios.tipo = 4
          AND usuarios.id IN
          (SELECT idpaciente from pacientesespecialistas 
          WHERE pacientesespecialistas.idespecialista = :id);";
    $datos = DB::execute_sql($query,$param)->fetchAll(PDO::FETCH_NAMED);// Se leen todos los datos de una vez
}


echo '<section class="header_class"> <h1> Mis Pacientes </h1> </section>';
//Creamos un formulario para permitir buscar filtrando por nombre
$form= "    <form action=\"showpatient.php\" method=\"POST\">
            <p>Busca por nombre:</p>
            <input type=\"text\" id= \"txtsearch\" onkeyup= \"updateSearch($id)\" name=\"search\"> <br><br>
            <button type=\"submit\">Buscar</button>
            </form>";
echo $form;
//Tabla y sus cabeceras
echo "<table id=\"tablapac\">";
echo "<tr>";
echo "<th class=\"fila_header\">Cuenta</th>";
echo "<th class=\"fila_header\">Nombre</th>";
echo "<th class=\"fila_header\">Ver Historial</th>";
echo "<th class=\"fila_header\">Añadir Anotacion</th>";
echo "</tr>";

//Datos de la tabla con botones para acceder o añadir anotación al historial de un paciente
foreach($datos as $registro){
    echo "<tr>";
    echo "<td class=\"fila_data\">{$registro['cuenta']}</td>";
    echo "<td class=\"fila_data\">{$registro['nombre']}</td>";
    echo "<td class=\"fila_data\"><form action='medichist.php' method=\"POST\">
	                              <input type='submit' value=\"Ver Historial\">
	                              <input type='hidden' name='id' value='${registro['id']}'>
	                              </form></td>";
	echo "<td class=\"fila_data\"><form action='addhist.php' method=\"POST\">
	                              <input type='submit' value=\"Añadir Anotacion\">
	                              <input type='hidden' name='iduser' value='${registro['id']}'>
	                              <input type='hidden' name='type' value='$tipo'>
	                              </form></td>";
    echo "</tr>";
}
echo '</table>';
View::end();//Finalizamos página
?>