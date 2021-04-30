<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if ($_POST['submit'] == 'creation') {
		try{
			$query = "INSERT INTO capteurs ( nom, id_capteur, date_on_service, limit_mini_temperature, limit_maxi_temperature, limit_mini_humidity, limit_maxi_humidity, position_x, position_y)
				VALUES ('".$_POST['nomCapteur']."',".$_POST['idCapteur'].",'".$_POST['dateCreation']."',".$_POST['seuilMiniTemperature'].",".$_POST['seuilMaxiTemperature'].",".$_POST['seuilMiniHumidite'].",".$_POST['seuilMaxiHumidite'].",".$_POST['positionX'].",".$_POST['positionY'].")";
				
			  $dbh->exec($query);
			  
			  } catch(Exception $e) {   
    echo $e->getMessage();
}

	}
}


