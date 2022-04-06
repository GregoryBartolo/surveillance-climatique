<!DOCTYPE html>
<html>
 
  <head>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    
    <?php include('sqlite_connection.php') ?>
    <?php include('modification_capteur.php') ?>
    <?php include('data_capteur.php') ?>


  </head>
 
  <body>
	<?php include('navbar.php') ?>
    <div class="container-fluid">
		
		<div class="row">
			<div class="col-8">
				<h2>Informations capteur</h2>
				<div class="row">
					<p class="col-3">Date : <?php echo $date; ?></p>
					<p class="col-2">Humidité : <?php echo $humidity; ?>%</p>
				</div>
				<div class="row">
					<p class="col-3">Température : <?php echo $temperature; ?>°C</p>
					<p class="col-2">Batterie : <?php echo $battery; ?>%</p>
				</div>
			</div>
			<div class="col align-self-center">
				<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalModification">
				  Modifier la station
				</button>
				<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalSuppression">
				  Supprimer la station
				</button>
			</div>
		</div>
		
		<div class="row">
			<!--<div id="chartContainer" style="height: 370px; width:80%;">-->
			<canvas id="myChart" width="200" height="64"></canvas>
		</div>
		
		<br>
		<h2>Informations station</h2>
		<div class="row">
			<p class="col-2">ID Capteur : <?php echo $infos_station['id_capteur']; ?></p>
			<p class="col-2">Nom station : <?php echo $infos_station['nom']; ?></p>
			<p class="col-3">Date de mise en service : <?php echo $infos_station['date_on_service']; ?></p>
			<p class="col-3">Dernier dépassement d'un seuil de température/humidité : <?php echo $infos_station['date_last_error']; ?></p>
		</div>
		<div class="row">
			<p class="col-2">Position X : <?php echo $infos_station['position_x']; ?></p>
			<p class="col-2">Seuil mini. de température : <?php echo $infos_station['limit_mini_temperature']; ?>°C</p>
			<p class="col-2">Seuil mini. d'humidité : <?php echo $infos_station['limit_mini_humidity']; ?>%</p>
		</div>
		<div class="row">
			<p class="col-2">Position Y : <?php echo $infos_station['position_y']; ?></p>
			<p class="col-2">Seuil maxi. de température : <?php echo $infos_station['limit_maxi_temperature']; ?>°C</p>
			<p class="col-2">Seuil maxi. de température : <?php echo $infos_station['limit_maxi_humidity']; ?>%</p>
		</div>
    </div>
  
    
    <!-- Fenetre modal modification valeurs station -->
    <div class="modal fade" id="modalModification" tabindex="-1" aria-labelledby="modalModification" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">Modification des valeurs</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		  </div>
		  <div class="modal-body">
			<form method="POST">
			  <div class="mb-3">
				<label for="nomCapteur" class="form-label">Nom capteur</label>
				<input type="text" class="form-control" name="nomCapteur" value="<?php echo $infos_station['nom']; ?>">
			  </div>
			  <div class="row mb-3">
				  <div class="col"><u>Température</u></div>
				  <div class="col"><u>Humidité</u></div>
			  </div>
			  <div class="row">
				  <div class="col">
					<div class="mb-3">
						<label for="seulMiniTemperature" class="form-label">Minimum</label>
						<input type="text" class="form-control" name="seuilMiniTemperature" value="<?php echo $infos_station['limit_mini_temperature']; ?>">
					</div>
					<div class="mb-3">
						<label for="seuilMaxiTemperature" class="form-label">Maximum</label>
						<input type="text" class="form-control" name="seuilMaxiTemperature" value="<?php echo $infos_station['limit_maxi_temperature']; ?>">
					</div>
				  </div>
				  <div class="col">
					<div class="mb-3">
						<label for="seuilMiniHumidite" class="form-label">Minimum</label>
						<input type="text" class="form-control" name="seuilMiniHumidite" value="<?php echo $infos_station['limit_mini_humidity']; ?>">
					</div>
					<div class="mb-3">
						<label for="seuilMaxiHumidite" class="form-label">Maximum</label>
						<input type="text" class="form-control" name="seuilMaxiHumidite" value="<?php echo $infos_station['limit_maxi_humidity']; ?>">
					</div>
				  </div>
			  </div>
			  
			  <div class="row mb-3">
				  <div class="col"><u>Position</u></div>
			  </div>
			  <div class="row">
				  <div class="col">
					<div class="mb-3">
						<label for="positionX" class="form-label">X</label>
						<input type="text" class="form-control" name="positionX" value="<?php echo $infos_station['position_x']; ?>">
					</div>
				  </div>
				  <div class="col">
					<div class="mb-3">
						<label for="positionY" class="form-label">Y</label>
						<input type="text" class="form-control" name="positionY" value="<?php echo $infos_station['position_y']; ?>">
					</div>
				  </div>
			  </div>
			  
			  <button type="submit" name="submit" class="btn btn-primary" value="modification">Sauvegarder</button>
			  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
			  
			</form>
		  </div>
		</div>
	  </div>
	</div>
	
	<!-- Fenetre modal suppression station -->
    <div class="modal fade" id="modalSuppression" tabindex="-1" aria-labelledby="modalSuppression" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">Voulez-vous vraiment supprimer la station n°<?php echo $infos_station['id_capteur']; ?> ?</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		  </div>
		  <div class="modal-footer">
			  <form method="post" >
				<button type="submit" name="submit" class="btn btn-danger" value="suppression">OUI</button>
				<button type="button" class="btn btn-primary" data-bs-dismiss="modal">ANNULER</button>
			  </form>
		  </div>
		</div>
	  </div>
	</div>
	
  </body>
 
</html>

<script src="js/popper.min.js"></script>
<script src="js/canvasjs.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/moment.js"></script>
<script src="js/utils.js"></script>
<script src="js/chart.min.js"></script>
<script src="js/chartjs-plugin-zoom.min.js"></script>
<script type="text/Javascript">
  var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
  var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
    return new bootstrap.Popover(popoverTriggerEl);
  });
  
  $('#exampleModal').on('shown.bs.modal', function () {
	})
  
  $(function () {
    $('[data-toggle="popover"]').popover({
        container: 'body'
    });
  })
	
	window.onload = function () {
		/*
		var chart = new CanvasJS.Chart("chartContainer", {
			animationEnabled: true,
			zoomEnabled: true,
			title:{
				text: "Les mesures" 
			},
			data: data 
		});
		chart.render();
		*/
		
		var ctx = document.getElementById('myChart').getContext('2d');
		
		var dates = <?php echo json_encode($dates); ?>;
		var temperatures = <?php echo json_encode($temperatures); ?>;
		var humidities = <?php echo json_encode($humidities); ?>;
		var batteries = <?php echo json_encode($batteries); ?>;
		
		const zoomOptions = {
		  pan: {
			enabled: true,
			mode: 'xy',
		  },
		  zoom: {
			wheel: {
			  enabled: true,
			},
			pinch: {
			  enabled: true
			},
			mode: 'xy',
		  }
		};
		
		
		const config = {
		  type: 'line',
		  data: {
			labels: dates,
			datasets: [{
			  label: 'Température',
			  data: temperatures,
			  fill: false,
			  borderColor: 'red',
			  tension: 0.1
			},
			{
			  label: 'Humidité',
			  data: humidities,
			  fill: false,
			  borderColor: 'blue',
			  tension: 0.1
			},
			{
			  label: 'Batterie',
			  data: batteries,
			  fill: false,
			  borderColor: 'green',
			  tension: 0.1
			}]
		  },
		  options: {
			plugins: {
			  zoom: zoomOptions,
			}
		  }
		};
		
		var myChart = new Chart(ctx, config);
	
	}

	/*
	var y = 0; var x = 0;
	var data = [];
	var dates = <?php echo json_encode($dates); ?>;
	var temperatures = <?php echo json_encode($temperatures); ?>;
	var humidities = <?php echo json_encode($humidities); ?>;
	var batteries = <?php echo json_encode($batteries); ?>;
	var dataSeriesTemperature = { type: "spline", name: "Température", showInLegend: true };
	var dataSeriesHumidity = { type: "spline", name: "Humidité", showInLegend: true };
	var dataSeriesBattery = { type: "spline", name: "Batterie", showInLegend: true };
	var dataPointsTemperatures = [];
	var dataPointsHumidities = [];
	var dataPointsBatteries = [];
	
	for (var i = 0; i < <?php echo count($temperatures); ?>; i += 1) {
		dataPointsTemperatures.push({
			x: new Date(moment(dates[i], "DD/MM/YYYY HH:mm:ss")),
			y: parseFloat(temperatures[i])
		});
	}
	
	for (var i = 0; i < <?php echo count($humidities); ?>; i += 1) {
		dataPointsHumidities.push({
			x: new Date(moment(dates[i], "DD/MM/YYYY HH:mm:ss")),
			y: parseFloat(humidities[i])
		});
	}
	
	for (var i = 0; i < <?php echo count($batteries); ?>; i += 1) {
		dataPointsBatteries.push({
			x: new Date(moment(dates[i], "DD/MM/YYYY HH:mm:ss")),
			y: parseFloat(batteries[i])
		});
	}
	dataSeriesTemperature.dataPoints = dataPointsTemperatures;
	dataSeriesHumidity.dataPoints = dataPointsHumidities;
	dataSeriesBattery.dataPoints = dataPointsBatteries;
	
	data.push(dataSeriesTemperature);
	data.push(dataSeriesHumidity);
	data.push(dataSeriesBattery);
	*/
	
</script>
