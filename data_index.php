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

$query = "SELECT DISTINCT id_capteur from capteurs";
$results = $dbh->query($query)->fetchAll();

$capteurs = array();
foreach ($results as $id_capteur) {
	$query = "SELECT MAX(mesures.id), * FROM mesures INNER JOIN capteurs WHERE mesures.id_capteur = ".$id_capteur['id_capteur'];
	$datas = $dbh->query($query)->fetchAll();
	
	$capteur = array();
	foreach ($datas as $value) {
		array_push($capteur, $value);
	}
	
	array_push($capteurs, $capteur);
}
