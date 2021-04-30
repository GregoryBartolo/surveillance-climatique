<?php

$query = "SELECT * FROM mesures LIMIT 1";
$result = $dbh->query($query)->fetch();
$id_capteur = $result['id_capteur'];
$infos_capteur = "<div>Température : ".$result['temperature']."°C</div><div>Humidité : ".$result['humidity']."%</div><div>Batterie restante : ".$result['battery']."%</div><div>Date : ".$result['date']."</div>";

