<?php
	if (isset($_GET['id_capteur']) && !empty($_GET['id_capteur']))
	{
		$query = "SELECT id_capteur FROM capteurs";
		$results = $dbh->query($query)->fetchAll();
		
		$exists = False;
		
		foreach ($results as $result) {
			foreach ($result as $id) {
				if ($id['id_capteur'] == $_GET['id_capteur'])
				{
					$exists = True;
				}
			}
		}
		
		if ($exists)
		{
			$query = "SELECT * FROM mesures where id_capteur=".$_GET['id_capteur'];
			$results = $dbh->query($query)->fetchAll();
			
			$temperatures = [];
			$humidities = [];
			$batteries = [];
			$dates = [];
			
			foreach ($results as $result) {
				array_push($temperatures, $result['temperature']);
				array_push($humidities, $result['humidity']);
				array_push($batteries, $result['battery']);
				array_push($dates, $result['date']);
			}
			
			$date = $dates[count($dates)-1];
			$humidity = $humidities[count($humidities)-1];
			$temperature = $temperatures[count($temperatures)-1];
			$battery = $batteries[count($batteries)-1];
			
			
			$query = "SELECT * FROM capteurs where id_capteur=".$_GET['id_capteur'];
			$infos_station = $dbh->query($query)->fetch();
		}
		else
		{
			header('Location:index.php');
			exit;
		}	


	}
	else
	{
		header('Location:index.php');
		exit;
	}	
