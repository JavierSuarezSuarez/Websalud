<?php
include_once 'presentation.class.php';
include_once 'data_access.class.php';
View::start('Actualización de Especialista','main_html');//Inicializamos página
View::navMain();//Inicializamos menú de navegación

//Obtenemos ids de especialistas a borrar y a añadir 
$idborrar = $_POST['idborrar'];
$idanadir = $_POST['idespec'];
//Obtenemos id el usuario logueado (paciente)
$user= User:: getLoggedUser();
$iduser = $user['id'];

$param =['idborrar' => $idborrar];
//Borramos la relación con el especialista a borrar
$SQL= "DELETE FROM pacientesespecialistas
       WHERE pacientesespecialistas.idespecialista = :idborrar";
DB:: execute_sql($SQL,$param);

$param =['idanadir' => $idanadir,
         'iduser' => $iduser];

//Insertamos la relación con el especialista a asignar
$SQL= "INSERT INTO pacientesespecialistas (idpaciente, idespecialista)\n
       VALUES (:iduser, :idanadir)";
DB:: execute_sql($SQL,$param); 
?>

<!--Cabecera y mensaje de actualización -->
<section class="header_class">
    <h1 > ¡Se ha actualizado un Especialista!</h1>
    
</section>

<?php
View:: end();//Finalizamos página
?>