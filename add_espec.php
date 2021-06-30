<?php
include_once 'presentation.class.php';
include_once 'data_access.class.php';
View::start('Agregar Especialidad a un Especialista','main_html');//Inicializamos página
View::navMain();//Inicializamos menú de navegación



/*Cuando se envia el formulario*/
if(isset($_POST['flag'])) {
    /*Recogemos datos introducidos*/
    $nombre= htmlentities($_POST['nombre']);
    $especialidad = htmlentities($_POST['especialidad']);
    
    //Se obtiene el id del especialista en base al nombre y se comprueba si tiene especialidad vacia
    $param = [ 'nombre' => $nombre ];
    $SQL = "SELECT idespecialista, especialidad FROM especialistas JOIN usuarios
            ON especialistas.idespecialista = usuarios.id WHERE 
            usuarios.nombre = :nombre";
    
    $datos = DB::execute_sql($SQL,$param)->fetchAll(PDO::FETCH_NAMED);
    
    foreach($datos as $dato) {
        $idespec = $dato['idespecialista'];
        if(strlen($dato['especialidad']) == 0) {
            $especvacia = $dato['especialidad'];
        }
    }
    
    //Se verifica si la especialidad pasada ya existe para evitar registros duplicados
    $param = [ 'especheck' => $especialidad,
               'nombre' => $nombre];
    $SQL = "SELECT especialidad FROM especialistas JOIN usuarios
            ON especialistas.idespecialista = usuarios.id WHERE 
            especialidad = :especheck AND nombre = :nombre;";
    $datos = DB::execute_sql($SQL,$param)->fetchAll(PDO::FETCH_NAMED);
    foreach($datos as $dato) {
        $especheck = $dato['especialidad'];
    }
    
    if(isset($idespec)) {
        //Se evitan registros duplicados
        if(isset($especheck)) {
            echo "<p class = \"p_style\" >Error: Datos ya introducidos</p>";
        //Si hay alguna especialidad vacia actualizamos
        }else if(isset($especvacia)) {
            $param = ['idespec' => $idespec,
                      'especialidad' => $especialidad];
            /*Actualizamos en especialistas la especialidad*/
            $SQL= "UPDATE especialistas 
               SET especialidad = :especialidad
               WHERE especialidad = \"\" and especialistas.idespecialista = :idespec;";
            DB:: execute_sql($SQL,$param); 
        //Si no hay especialidades vacias insertamos
        }else {
            //Añadimos un nuevo registro con la nueva especialidad
            $param = ['idespec' => $idespec,
                      'especialidad' => $especialidad];
            $SQL= "INSERT INTO especialistas (idespecialista, especialidad) 
                   VALUES (:idespec, :especialidad);";
            DB:: execute_sql($SQL,$param); 
        }          
        
    } else {
        echo "<p class = \"p_style\" >Error: El especialista con nombre $nombre no esta registrado</p>";
    }
}

?>

<!---------------------Seccion Principal con Formulario------------------------>
<section class="header_class">
    <h1  > Agregar Especialidad a un Especialista</h1>
</section>

<section>
    <form method="POST" action="add_espec.php">
        <fieldset>
		    <label>Nombre: </label> <input name="nombre" type="text" required><br>
		    <label>Especialidad: </label> <input name="especialidad" type="text" required><br>
		    <!--Para Envio-->
		    <input type="text" name="flag" value="true" hidden>
		    <input type="submit" value="Agregar"><br>
		</fieldset>
    </form>
</section>


<?php
View:: end(); //Finalizamos página
?>