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
    <div class="container-fluid">

		<?php include('navbar.php') ?>
		
		<h2>Informations capteur</h2>
		<div class="row">
			<p class="col-2">Date : <?php echo $date; ?></p>
			<p class="col-2">Humidité : <?php echo $humidity; ?>%</p>
		</div>
		<div class="row">
			<p class="col-2">Température : <?php echo $temperature; ?>°C</p>
			<p class="col-2">Batterie : <?php echo $battery; ?>%</p>
		</div>
		
		<div class="row">
			<div class="col-8">
				<canvas id="myChart"></canvas>
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
		
		<br>
		<h2>Informations station</h2>
		<div class="row">
			<p class="col-2">ID Capteur : <?php echo $infos_station['id_capteur']; ?></p>
			<p class="col-2">Nom station : <?php echo $infos_station['nom']; ?></p>
			<p class="col-3">Date de mise en service : <?php echo $infos_station['date_on_service']; ?></p>
			<p class="col-3">Date de dernière erreur : <?php echo $infos_station['date_last_error']; ?></p>
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
<script src="js/chart.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.min.js"></script>
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
	
	const labels = <?php echo json_encode($dates); ?>;
	const data = {
	  labels: labels,
	  datasets: [{
		label: 'Température',
		borderColor: 'red',
		data: <?php echo json_encode($temperatures); ?>,
	  },
	  {
		label: 'Humidité',
		borderColor: 'green',
		data: <?php echo json_encode($humidities); ?>,
	  },
	  {
		label: 'Batterie',
		borderColor: 'blue',
		data: <?php echo json_encode($batteries); ?>,
	  }]
	};
	const config = {
	  type: 'line',
	  data,
	  options: {}
	};
	var myChart = new Chart(
		document.getElementById('myChart'),
		config
	);
</script>
