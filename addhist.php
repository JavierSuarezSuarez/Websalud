<?php
include_once 'presentation.class.php';
include_once 'data_access.class.php';
View::start('Agregar anotación','main_html');//Inicializamos página
View::navMain();//Inicializamos menú de navegación

/*Se comprueba si ha accedido a esta página el auxiliar o el especialista*/
if(isset($_POST['type'])) {
    $typecread = $_POST['type'];
    $idusuario = $_POST['iduser'];
} else {
    $user = User:: getLoggedUser();
    $typecread = $user['tipo'];
}
$user = User:: getLoggedUser();
$idcrea = $user['id'];

/*Para cuando se envia el formulario*/
if(isset($_POST['flag'])) {
    $idpac = htmlentities($_POST['idpac']);
    $fyh = htmlentities($_POST['date']);
    $tipo = htmlentities($_POST['typeform']);
    $asunto = htmlentities($_POST['subject']);
    $desc= htmlentities($_POST['desc']);
    
    $param = ['idpac' => $idpac];
    //Para comprobar id del paciente
    $checkid="SELECT tipo FROM usuarios WHERE usuarios.id = :idpac;";
    $datos = DB::execute_sql($checkid,$param)->fetchAll(PDO::FETCH_NAMED);
    foreach($datos as $dato) {
        $typecheck = $dato['tipo'];
    }
/*--------------------Restricciones  en los datos del historial----------------*/
    $testdate = @explode('-',$fyh);    //Para comprobar la fecha (DD,mm,YY HH:mm)
    $aux = @explode(' ', $testdate[2]);//Para comprobar la fecha (YY, HH:mm)
    
    //Comprobacion de id del paciente
    if(@strlen($typecheck) < 1 or $datos[0]['tipo'] != 4) {
        echo "<p class=\"p_style\">Error: Paciente incorrecto</p>";
    
    //Comprobacion de fecha
    }else if(@checkdate($testdate[1], $testdate[0], $aux[0]) == false) {
        echo "<p class=\"p_style\">Error: Fecha en fomato inválido, el formato es: DD-MM-YYYY HH:mm AM/PM</p>";
        
     //Comprobacion de tipo
    }else if($tipo < 1 or $tipo > 5) {
        echo "<p class=\"p_style\">Error: El tipo debe estar en el rango 1-5</p>";
        
     //Comprobacion de asunto    
    }else if(strlen($asunto) < 1 or strlen($asunto) > 32) {
        echo "<p class=\"p_style\">Error: En el asunto se permiten de 1 a 32 caracteres</p>";
        
     //Comprobacion de descripción  
    }else if(strlen($desc) < 12 or strlen($desc) > 5000) {
        echo "<p class=\"p_style\">Error: En la descripción debe haber un mínimo de 12 caracteres y máximo 5000</p>";
        
     //Comprobacion de tipo si se es auxiliar  
    }else if( $typecread == 3 and $tipo != 5) {
        echo "<p class=\"p_style\">Error: Como auxiliar solo puede añadir pruebas clínicas</p>";
        
     //Comprobacion de tipo si se es especialista     
    }else if($typecread == 2 and $tipo > 4) {
        echo "<p class=\"p_style\">Error: No se pueden añadir pruebas clínicas con este rol</p>";
        
    }else {
        //Ejecucion SQL y añadido
        $fyhmod = strtotime($fyh); //Formateo fecha para insercion en BD
        $param = [ 'idpac' => $idpac,
                   'fyhmod' => $fyhmod,
                   'idcrea' => $idcrea,
                   'tipo' => $tipo,
                   'asunto' => $asunto,
                   'desc' => $desc ];
                
        $SQL= "INSERT INTO historial (idpaciente, fechahora, idcreador, tipo, asunto, descripcion)
               VALUES (:idpac,  :fyhmod, :idcrea, :tipo, :asunto, :desc);";
        DB:: execute_sql($SQL,$param); 
        echo "<p class=\"p_style\">Se ha añadido con éxito su solicitud</p>";
    }
}
?>

<!--------------------------------Seccion principal---------------------------->
<section class="header_class">
    <h1  > Agregar anotación </h1>
</section>

<!----------------Formulario para añadir anotaciones al historial-------------->
<section>
    <form method="POST" onsubmit = "return checkSubjDesc()" action="addhist.php">
        <fieldset>
            <!--Dependiendo de si el rol es especialista o no, se podrá editar o no el id paciente
                ya que si se es especialista, al elegir paciente en la tabla, se debe coger id del paciente-->
            <?php
            if($typecread == 2) {
                echo "<label>ID del paciente: </label> <input value= \"$idusuario\"name=\"idpac\" type=\"text\" readonly><br>";
            } else {
                echo "<label>ID del paciente: </label> <input name=\"idpac\" type=\"text\"><br>";
            }
            ?>
		    <label>Fecha y Hora: </label> <input name="date" type="text" placeholder="DD-MM-YYYY HH:mm AM/PM"><br>
		    <label>Tipo: </label><input name="typeform" type="text" ><br>
		    <label>Asunto: <input id="as" name="subject" type="text">
		           <span id="errorasunto" class="span_style"></span><br>
		    </label>
		    <label>Descripción: <input id="des" name="desc" type="text"> 
		           <span id="errordesc" class="span_style" ></span><br>
		    </label>
		    
		    <!--Para Envio-->
		    <input type="text" name="flag" value="true" hidden>
		    <input type='hidden' name='iduser' value="<?=$idusuario?>">
		    <input type='hidden' name='type' value="<?=$typecread?>">
		    <input type="submit" value="Agregar"><br>
		</fieldset>
    </form>
</section>


<?php
View:: end(); //Finalizamos página
?>