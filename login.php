<?php
include_once 'presentation.class.php';
include_once 'data_access.class.php';
include_once 'business.class.php';

View::start('Iniciar Sesión','main_html');//Inicializamos página
View::navPagSecun();//Inicializamos menú de navegación
$login = true;//Flag para saber si datos introducidos son correctos

//Si se han escrito los datos
if(isset($_POST["flag"])){
    $user = htmlentities($_POST["user"]);
    $password = htmlentities($_POST["pwd"]);
    //Comprobamos si el usuario existe y si es asi vamos a página principal
    if(User::login($user,$password)) {
        header('Location: index.php');
    } else {
        $login=false;
    }
}
?>

<!---------------------------Seccion central login.php------------------------->
<section class="header_class">
    <h1  > Iniciar Sesión </h1>
</section>

<div>
    <form class="loginform" method="POST" action="login.php">
        <fieldset>
            <!--Para nombre usuario-->
		    <label> Usuario: </label> <input name="user" type="text"><br>
		    <!--Para contraseña-->
		    <label>Contraseña: </label><input name="pwd" type="password" ><br>
		    <!--Para Envio-->
		    <input type="text" name="flag" value="true" hidden>
		    <input type="submit" value="Iniciar sesión"><br>
		</fieldset>
    </form>
    <?php
    if(!$login) {
        echo "<p class = \"p_style\" >Datos de acceso incorrectos</p>";
    }
    ?>
</div>

<?php
View::end();//Finalizamos página
?>