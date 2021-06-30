<?php
include_once 'presentation.class.php';
include_once 'data_access.class.php';
include_once 'business.class.php';

View::start('Asignación Especialistas','main_html');//Inicializamos página
View::navMain();//Inicializamos menú de navegación

//Obtenemos id de usuario logueado y de especialista pasado por URL
$user= User:: getLoggedUser();
$iduser = $user['id'];
$idespec = $_POST['idespec'];

$param= ['iduser' => $iduser,
         'idespec' => $idespec];

//Insertamos en la tabla que relaciona pacientes y especialistas un nuevo registro
$SQL= "INSERT INTO pacientesespecialistas (idpaciente, idespecialista)
       VALUES (:iduser, :idespec)";
DB:: execute_sql($SQL,$param); 

?>
<!-- Se confirma en la página la asignación-->
<section class="header_class">
    <h1 > ¡Asignación completada!</h1>
    
</section>

<?php
View:: end();//Finalizamos página
?>