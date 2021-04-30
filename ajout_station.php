<!DOCTYPE html>
<html>
 
  <head>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/datepicker.css">
    
    <?php include('sqlite_connection.php') ?>
    <?php include('ajout_capteur.php') ?>


  </head>
 
  <body>
    <div class="container-fluid">

	<?php include('navbar.php') ?>
	
		<h2>Ajout d'un capteur</h2>
		<div class="row">
			<div class="col-6">
				<form method="POST">
				  <div class="mb-3">
					  <div class="row"> 
						  <div class="col">
						<label for="idCapteur" class="form-label">ID capteur</label>
						<input type="text" class="form-control" name="idCapteur">	  
						  </div>
						  <div class="col">
						<label for="nomCapteur" class="form-label">Nom capteur</label>
						<input type="text" class="form-control" name="nomCapteur">
						  </div>						  
						
					 </div>
				  </div>
				  <div class="mb-3">
					<label for="dateCreation" class="form-label">Date de création</label>
					<input type="text" class="form-control datepicker" name="dateCreation">
				  </div>
				  <div class="row mb-3">
					  <div class="col"><u>Température</u></div>
					  <div class="col"><u>Humidité</u></div>
				  </div>
				  <div class="row">
					  <div class="col">
						<div class="mb-3">
							<label for="seulMiniTemperature" class="form-label">Minimum</label>
							<input type="text" class="form-control" name="seuilMiniTemperature">
						</div>
						<div class="mb-3">
							<label for="seuilMaxiTemperature" class="form-label">Maximum</label>
							<input type="text" class="form-control" name="seuilMaxiTemperature">
						</div>
					  </div>
					  <div class="col">
						<div class="mb-3">
							<label for="seuilMiniHumidite" class="form-label">Minimum</label>
							<input type="text" class="form-control" name="seuilMiniHumidite">
						</div>
						<div class="mb-3">
							<label for="seuilMaxiHumidite" class="form-label">Maximum</label>
							<input type="text" class="form-control" name="seuilMaxiHumidite">
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
							<input type="text" class="form-control" name="positionX">
						</div>
					  </div>
					  <div class="col">
						<div class="mb-3">
							<label for="positionY" class="form-label">Y</label>
							<input type="text" class="form-control" name="positionY">
						</div>
					  </div>
				  </div>
				  
				  <button type="submit" name="submit" class="btn btn-primary" value="creation">Ajouter</button>  
				</form>
			</div>
		</div>
	
    
  </body>
 
</html>

<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<script src="js/locales/bootstrap-datepicker.fr.js"></script>
<script type="text/Javascript">
  var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
  var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
    return new bootstrap.Popover(popoverTriggerEl);
  });

   $('.datepicker').datepicker({
      format: 'dd-mm-yyyy',
      language: 'fr'
    });
    
</script>
