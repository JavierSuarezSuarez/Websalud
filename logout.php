<?php
include_once 'presentation.class.php';
include_once 'data_access.class.php';
include_once 'business.class.php';

//Cerramos sesión y vamos a página principal
User::logout();
header('Location: index.php');
