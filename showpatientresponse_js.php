<?php
include_once 'data_access.class.php';

try {
    $datosjson = file_get_contents("php://input");
    $datos=json_decode($datosjson,true);
    
    if(isset($datos['txtsearch']) and isset($datos['id']) ) {
        $txtsearch = $datos['txtsearch'];
        $param = ['txtsearch' => "%$txtsearch%",
                  'id' => $datos['id']];
        $SQL="SELECT id, cuenta, nombre FROM usuarios WHERE usuarios.tipo = 4 AND nombre LIKE :txtsearch
              AND usuarios.id IN
              (SELECT idpaciente from pacientesespecialistas 
              WHERE pacientesespecialistas.idespecialista = :id);";
            
        $datosSQL = DB::execute_sql($SQL,$param)->fetchALL(PDO::FETCH_NAMED);
        $datosres = array();
        $datosres['result'] = $datosSQL;
    }
    header('Content-type: application/json');
    echo json_encode($datosres);
} catch(Exception $e) {

}


?>

