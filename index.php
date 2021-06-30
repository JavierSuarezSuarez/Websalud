<?php
include_once 'presentation.class.php';
include_once 'data_access.class.php';
View::start('Clínica WebSalud','main_html');//Inicializamos página
View::navMain();//Inicializamos menú de navegación
?>

<!--------------------------Seccion central index.php-------------------------->
<section class="header_class">
    <h1  > WebSalud </h1>
</section>

<div id="welcome_text">
    <p> Bienvenido a WebSalud,</p>
    <p> 
        En WebSalud nos preocupamos por tu bienestar y para ello tenemos a los 
        mejores especialistas procedentes de las mejores Universidades del mundo.
        Poseemos un equipamiento médico moderno que nos permite ofrecerte un 
        excelente servicio. Hemos obtenido premios internacionales en nuestro área 
        de cardiología valorando nuestro buen hacer, lo que nos sitúa, según los expertos,
        como la mejor clínica privada con ámbito en cardiología de Gran Canaria.
        Por todo ello, garantizamos que estarás en buenas manos.
        <img id="img_Rotulo"  src="img/logo.JPG" alt="Rotulo">
    </p>
    <p id="index_italic_text"> WebSalud, tu clínica de confianza.</p>
</div>

<?php
View::footer(); //Finalizamos página
?>