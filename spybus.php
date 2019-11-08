<?php
ini_set("display_errors", 1);

set_error_handler(function ($err_severity, $err_msg, $err_file, $err_line, array $err_context)
{
    throw new ErrorException( $err_msg, 0, $err_severity, $err_file, $err_line );
}, E_WARNING);
$conn = new mysqli('g3v9lgqa8h5nq05o.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', 'ztw23x4aswwp0ysq', 'uwhcmfz0snef9fmp', 'hf0d5zbejew4ut82');
// Check connection
if ($conn->connect_error) {
	bdLog("[".date('d-m-Y H:i:s')."]Falha de Conexão: " . $conn->connect_error);
	die();
}

$linhas = json_decode(file_get_contents("AllLines.txt"), TRUE);
$busStop = json_decode(file_get_contents("AllPoints.txt"), TRUE);

foreach($linhas as $l){
	
	$path = json_decode(requisicao_handle("http://zn5.m2mcontrol.com.br/api/forecast/lines/load/pattern/".$l["id"]."/1228"), TRUE);
	
	try{
		$xxx = json_decode(requisicao_handle("http://zn5.m2mcontrol.com.br/api/forecast/lines/load/all/forecast/".$busStop[array_search($path[0]["type"],array_column($busStop,"name"))]["id"]."/".$path[0]["id"]."/1228"), TRUE);
		for($i = 0; $i < count($xxx);$i++){
			salvaBd((int)preg_replace("/[^0-9]/", "", $xxx[$i]["codVehicle"]),str_replace("'", "", $xxx[$i]["patternName"]),$xxx[$i]["arrivalTime"],$conn);
		}
		$xxx2 = json_decode(requisicao_handle("http://zn5.m2mcontrol.com.br/api/forecast/lines/load/all/forecast/".$busStop[array_search($path[1]["type"],array_column($busStop,"name"))]["id"]."/".$path[1]["id"]."/1228"), TRUE);
		for($i = 0; $i < count($xxx2);$i++){
			salvaBd((int)preg_replace("/[^0-9]/", "", $xxx2[$i]["codVehicle"]),str_replace("'", "", $xxx2[$i]["patternName"]),$xxx2[$i]["arrivalTime"],$conn);
		}
	}catch(Exception $e){
		bdLog("[Erro]: ".$l["name"]." não existe ou apresentou erro.<br>");
	}
}

$conn->close();
//Funções
function salvaBd($codOnibus,$rota,$tempo,$conn) {		
	
	$sql = "INSERT INTO num_onibus(id_onibus,rota,tempo_restante) VALUES ($codOnibus, '$rota', $tempo) ON DUPLICATE KEY UPDATE rota = '$rota',tempo_restante = $tempo";
	if(!$conn->query($sql) == TRUE){		
		echo(mysqli_error($conn)."\n");
	}
}
function bdLog($text){
		date_default_timezone_set("America/Fortaleza");
		$nomearquivo = "./logs/".date('d-m-Y').".txt";
		$log = fopen($nomearquivo, 'a');
		fwrite($log, $text);
		fclose($log);
	}
function requisicao_handle($url)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	return curl_exec($ch);
}