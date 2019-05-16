<?php
set_time_limit(0);
if(!file_exists("AllLines.txt") & !file_exists("AllPoints.txt")){
	copy("http://zn5.m2mcontrol.com.br/api/forecast/lines/load/allLines/1228","AllLines.txt");
	copy("http://zn5.m2mcontrol.com.br/api/forecast/lines/load/allPoints/1228","AllPoints.txt");	
}

$linhas = json_decode(file_get_contents("AllLines.txt"), TRUE);
$busStop = json_decode(file_get_contents("AllPoints.txt"), TRUE);

foreach($linhas as $l){
	
	$path = json_decode(file_get_contents("http://zn5.m2mcontrol.com.br/api/forecast/lines/load/pattern/".$l["id"]."/1228"), TRUE);
	
	try{
		$xxx = json_decode(@file_get_contents("http://zn5.m2mcontrol.com.br/api/forecast/lines/load/all/forecast/".$busStop[array_search($path[0]["type"],array_column($busStop,"name"))]["id"]."/".$path[0]["id"]."/1228"), TRUE);
		for($i = 0; $i < count($xxx);$i++){
			print_r("[".$xxx[$i]["codVehicle"]."]".$xxx[$i]["patternName"].": ".$xxx[$i]["arrivalTime"]." minutos<br>");
		}
		$xxx2 = json_decode(@file_get_contents("http://zn5.m2mcontrol.com.br/api/forecast/lines/load/all/forecast/".$busStop[array_search($path[1]["type"],array_column($busStop,"name"))]["id"]."/".$path[1]["id"]."/1228"), TRUE);
		for($i = 0; $i < count($xxx2);$i++){
			print_r("[".$xxx2[$i]["codVehicle"]."]".$xxx2[$i]["patternName"].": ".$xxx2[$i]["arrivalTime"]." minutos<br>");
		}
	}catch(Exception $e){
		print_r("[Erro]: ".$l["id"]." não existe ou apresentou erro.<br>");
	}
}