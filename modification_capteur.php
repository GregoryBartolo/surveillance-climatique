<?php

$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if ($_POST['submit'] == 'modification') {
		try {
			$query = "UPDATE capteurs
				SET nom = '".$_POST['nomCapteur']."',
				  limit_mini_temperature = '".$_POST['seuilMiniTemperature']."',
				  limit_maxi_temperature = '".$_POST['seuilMaxiTemperature']."',
				  limit_mini_humidity = '".$_POST['seuilMiniHumidite']."',
				  limit_maxi_humidity = '".$_POST['seuilMaxiHumidite']."',
				  position_x = '".$_POST['positionX']."',
				  position_y = '".$_POST['positionY']."'
				WHERE id_capteur = ".$_GET['id_capteur'];
			
			  $dbh->exec($query);
		}
		catch(Exception $e) {   
			echo $e->getMessage();
		}

	}
	else if ($_POST['submit'] == 'suppression') {
		try {
			$query = "DELETE FROM capteurs WHERE id_capteur = ".$_GET['id_capteur'];
			
			  $dbh->exec($query);
			  
		}
		catch(Exception $e) {   
			echo $e->getMessage();
		}
	}
}
