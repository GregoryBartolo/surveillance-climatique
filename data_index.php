<?php

#$query = "SELECT DISTINCT mesures.id_capteur, temperature, humidity, battery, date, capteurs.position_x, capteurs.position_y FROM mesures INNER JOIN capteurs WHERE (mesures.id IN (SELECT MAX(id) FROM mesures GROUP BY id_capteur))";
#$results = $dbh->query($query)->fetchAll();
#$results = array_slice($results, 0, count($results)/2);

#print_r($results);

#foreach ($results as $value) {
#	foreach ($value as $key => $item) {
#		print_r($key);
#		print_r($item);
#		echo '<br>';
#	}
#}

#$id_capteur = $result['id_capteur'];
#$infos_capteur = "<div>Température : ".$result['temperature']."°C</div><div>Humidité : ".$result['humidity']."%</div><div>Batterie restante : ".$result['battery']."%</div><div>Date : ".$result['date']."</div>";

$query = "SELECT DISTINCT id_capteur, position_x, position_y from capteurs";
$results = $dbh->query($query)->fetchAll();

$capteurs = array();
foreach ($results as $id_capteur) {
	$query = "SELECT MAX(mesures.id), * FROM mesures INNER JOIN capteurs WHERE mesures.id_capteur = ".$id_capteur['id_capteur']. " AND capteurs.id_capteur = ".$id_capteur['id_capteur'];
	$datas = $dbh->query($query)->fetchAll()[0];
	
	if (empty($datas['id'])) {
		$id_capteur['content'] = "Pas de mesure.";
		$id_capteur['depassement'] = "primary";
		array_push($capteurs, $id_capteur);
	}
	else {
		$battery = $datas['battery']." %";
		if ($datas['battery'] < 15) {
			$battery = "<span class='erreurValeur'>".$datas['battery']."%</span>"; 
		}

		$temperature = $datas['temperature']."°C";
		if ($datas['temperature'] > $datas['limit_maxi_temperature'] or $datas['temperature'] < $datas['limit_mini_temperature']) {
			$temperature = "<span class='erreurValeur'>".$datas['temperature']."°C</span>"; 
		}
		
		$humidity = $datas['humidity']."%";
		if ($datas['humidity'] > $datas['limit_maxi_humidity'] or $datas['humidity'] < $datas['limit_mini_humidity'] ) {
			$humidity = "<span class='erreurValeur'>".$datas['humidity']."%</span>"; 
		}
		
		$content = "Date : ".$datas['date'] ."<br> Temperature : ".$temperature." <br> Humidite : " .$humidity ." <br> Batterie : " .$battery;
		$datas['content'] = $content;
		
		if ($datas['temperature'] > $datas['limit_maxi_temperature'] or $datas['temperature'] < $datas['limit_mini_temperature'] or $datas['humidity'] > $datas['limit_maxi_humidity'] or $datas['humidity'] < $datas['limit_mini_humidity'] or $datas['battery'] < 15)
		{
			$datas['depassement'] = "danger";
		}
		else
		{
			$datas['depassement'] = "primary";
		}
			
		array_push($capteurs, $datas);
	}
}
