<?php
include_once 'presentation.class.php';
include_once 'data_access.class.php';
View::start('Modificar Especialidad','main_html');//Inicializamos página
View::navMain();//Inicializamos menú de navegación

$id = $_POST['id']; //Obtenemos id de especialista a actualizar por URL
$especURL = $_POST['espec'];//Obtenemos especialidad previa por si es nula la que se introduce

//Si se ha enviado el formulario
if(isset($_POST['flag'])) {
    /*Campo recogidos en formulario*/
    $especialidadpass = htmlentities($_POST['especialidad']);
    
    /*Comprobación de nulidad del campo y cambio si lo es*/
    $especialidad = strlen($especialidadpass) == 0 ? $especURL : $especialidadpass;
    

    //Se verifica si la especialidad pasada ya existe para evitar registros duplicados
    $param = [ 'espec' => $especialidad,
               'id' => $id];
    $SQL = "SELECT especialidad FROM especialistas WHERE 
            especialidad = :espec AND idespecialista = :id;";
    $datos = DB::execute_sql($SQL,$param)->fetchAll(PDO::FETCH_NAMED);
    foreach($datos as $dato) {
        $especheck = $dato['especialidad'];
    }
    
    if(isset($especheck)) {
        echo "<p class = \"p_style\" >Error: Datos ya introducidos</p>";
    }else {
        $param = ['especialidad' => $especialidad,
              'id' => $id,
              'especURL' => $especURL];
        /*Actualizamos registros de especialistas*/
        $SQL= "UPDATE especialistas
               SET especialidad= :especialidad
               WHERE especialistas.idespecialista= :id and especialidad = :especURL;";
        DB:: execute_sql($SQL,$param); 
        header('Location: managespec.php');
    }
    
}
?>

<section class="header_class">
    <h1  > Modificar Especialidad</h1>
</section>

<!--Formulario para realizar modificaciones de especialidad. Tipo siempre a 2-->
<section>
    <form method="POST" action="modify_espec.php">
        <fieldset>
		    <label>Especialidad: </label> <input name="especialidad" value="<?=$especURL?>" type="text"><br>
		    
		    <!--Para Envio-->
		    <input type="text" name="flag" value="true" hidden>
		    <input type='hidden' name='id' value="<?=$id?>">
		     <input type='hidden' name='espec' value="<?=$especURL?>">
		    <input type="submit" value="Confirmar Cambios"><br>
		</fieldset>
    </form>
</section>


<?php
View:: end();//Finalizamos página
?>