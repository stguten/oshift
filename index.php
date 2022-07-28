<?php
list($usec, $sec) = explode(' ', microtime());
$script_start = (float) $sec + (float) $usec;

ini_set("display_errors", 0);
set_time_limit(0);
/*set_error_handler(function ($err_severity, $err_msg, $err_file, $err_line, array $err_context)
{
    throw new ErrorException( $err_msg, 0, $err_severity, $err_file, $err_line );
}, E_WARNING);*/

copy("http://zn5.m2mcontrol.com.br/api/forecast/lines/load/allLines/1228","AllLines.txt");
copy("http://zn5.m2mcontrol.com.br/api/forecast/lines/load/allPoints/1228","AllPoints.txt");	

$linhas = json_decode(file_get_contents("AllLines.txt"), TRUE);
$busStop = json_decode(file_get_contents("AllPoints.txt"), TRUE);

foreach ($linhas as $l) {

	$path = json_decode(requisicao_handle("http://zn5.m2mcontrol.com.br/api/forecast/lines/load/pattern/" . $l["id"] . "/1228"), TRUE);
	//print_r($path);

	try {
		//print_r("https://zn5.m2mcontrol.com.br/api/forecast/lines/load/all/forecast/" . $busStop[array_search($path[0]["type"], array_column($busStop, "name"))]["id"] . "/" . $path[0]["id"] . "/1228\n");
		$xxx = json_decode(requisicao_handle("http://zn5.m2mcontrol.com.br/api/forecast/lines/load/all/forecast/" . $busStop[array_search($path[0]["type"], array_column($busStop, "name"))]["id"] . "/" . $path[0]["id"] . "/1228"), TRUE);
		if (!empty($xxx)) {
			for ($i = 0; $i < count($xxx); $i++) {
				print_r("[".substr_replace($xxx[$i]["codVehicle"], '.', 3, 0)."]".$xxx[$i]["patternName"].": ".$xxx[$i]["arrivalTime"]." minutos.(<a href=\"https://www.google.com/maps/place/".$xxx[$i]["latLng"]["lat"].",+".$xxx[$i]["latLng"]["lng"]."\" target=\"_blank\">Localização no mapa</a>)<br>");
				//print_r("https://zn5.m2mcontrol.com.br/api/forecast/lines/load/all/forecast/" . $busStop[array_search($path[0]["type"], array_column($busStop, "name"))]["id"] . "/" . $path[0]["id"] . "/1228\n");
				//print_r("[" . $xxx[$i]["codVehicle"] . "]" . $xxx[$i]["patternName"] . ": " . $xxx[$i]["arrivalTime"] . " minutos.\n");
			}
		}
		$xxx2 = @json_decode(requisicao_handle("http://zn5.m2mcontrol.com.br/api/forecast/lines/load/all/forecast/" . $busStop[array_search($path[1]["type"], array_column($busStop, "name"))]["id"] . "/" . $path[1]["id"] . "/1228"), TRUE);
		if (!empty($xxx)) {
			for ($i = 0; $i < count($xxx2); $i++) {
				print_r("[".substr_replace($xxx2[$i]["codVehicle"], '.', 3, 0)."]".$xxx2[$i]["patternName"].": ".$xxx2[$i]["arrivalTime"]." minutos.(<a href=\"https://www.google.com/maps/place/".$xxx2[$i]["latLng"]["lat"].",+".$xxx2[$i]["latLng"]["lng"]."\" target=\"_blank\">Localização no mapa</a>)<br>");
				//print_r("https://zn5.m2mcontrol.com.br/api/forecast/lines/load/all/forecast/" . $busStop[array_search($path[1]["type"], array_column($busStop, "name"))]["id"] . "/" . $path[0]["id"] . "/1228\n");
				//print_r("[" . $xxx2[$i]["codVehicle"] . "]" . $xxx2[$i]["patternName"] . ": " . $xxx2[$i]["arrivalTime"] . " minutos.\n");
			}
		}
	} catch (Exception $e) {
		print_r("[Erro]: " . $l["name"] . " não existe ou apresentou erro.<br>");
	}
}
list($usec, $sec) = explode(' ', microtime());
$script_end = (float) $sec + (float) $usec;
$elapsed_time = round($script_end - $script_start, 5);

echo '<b>Tempo total</b>: ', $elapsed_time, ' secs. <b>Uso de memoria</b>: ', round(((memory_get_peak_usage(true) / 1024) / 1024), 2), 'Mb';

function requisicao_handle($url)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	return curl_exec($ch);/* 
	$resposta =  curl_exec($ch);
	print_r($resposta); */
}
