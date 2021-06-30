<?php
include_once 'data_access.class.php';
$res = new stdClass();
$res -> deleted=false;
$res -> message='';
try {
    $datosjson = file_get_contents("php://input");
    $datos=json_decode($datosjson,true);
    $param=['idpac' => $datos['idpac'],
            'idespec' => $datos['idespec']];
    $SQL = "DELETE FROM pacientesespecialistas WHERE idespecialista=:idespec AND
            idpaciente=:idpac";
    DB::execute_sql($SQL,$param);
    
    $SQL = "SELECT * FROM pacientesespecialistas WHERE idespecialista=:idespec AND
            idpaciente=:idpac";
    $datos2 = DB::execute_sql($SQL,$param)->fetchAll(PDO::FETCH_NAMED);
    if(sizeof($datos2) == 0) {
        $res->deleted=true;
    }
}catch(Exception $e) {
    $res -> message=$e->getMessage();
}
header('Content-type: application/json');
echo json_encode($res);

?>