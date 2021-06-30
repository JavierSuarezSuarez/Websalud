<?php
include_once 'presentation.class.php';
include_once 'data_access.class.php';
View::start('Eliminar Especialidad','main_html');//Inicializamos página
View::navMain();//Inicializamos menú de navegación

$id = $_POST['id'];//Obtenemos id de especialista cuya especialidad vamos a eliminar
$especprev = $_POST['espec'];//Obtenemos especialidad a cambiar de especialista 

$param = ['id' => $id,
          'especprev' => $especprev];
/*Consultas para actualizar la tabla especialista al valor "" debido a que posee
  restricción NOT NULL*/
$SQL= "UPDATE especialistas
       SET especialidad = \"\"
       WHERE especialistas.idespecialista = :id AND especialistas.especialidad = :especprev;";
DB:: execute_sql($SQL,$param); 

?>

<!----------------Seccion principal con mensaje-------------------------------->
<section class="header_class">
    <h1 > ¡Se ha eliminado una Especialidad!</h1>
    
</section>
<?php
View:: end();//Finalizamos página
?>