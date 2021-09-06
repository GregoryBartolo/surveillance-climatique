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
    <?php include('navbar.php') ?>
    <?php include('data_ajout_station.php') ?>
    <div class="container-fluid">
	
	<h2 class="mt-3">Ajout d'un capteur</h2>
	<div class="row">
	    <div class="col-3">
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
			    <input type="text" class="form-control inputPositionX" name="positionX" onkeyup="changePosition('x')">
			</div>
		      </div>
		      <div class="col">
			<div class="mb-3">
			    <label for="positionY" class="form-label">Y</label>
			    <input type="text" class="form-control inputPositionY" name="positionY" onkeyup="changePosition('y')">
			</div>
		      </div>
		  </div>
		  
		  <button type="submit" name="submit" class="btn btn-primary" value="creation">Ajouter</button>  
		</form>
	    </div>
	    <div class="col">
		<div class="mt-3 row">
		    <div class="col-3">
		    </div>
		    <div class="col-6">
		      <table class="entete-table">
			<tr><td class="entete-td">00</td><td class="entete-td">10</td><td class="entete-td">20</td><td class="entete-td">30</td><td class="entete-td">40</td><td class="entete-td">50</td><td class="entete-td">60</td><td class="entete-td">70</td><td class="entete-td">80</td><td class="entete-td">90</td></tr>
		      </table>
		    </div>
		  </div>
		  <div class="row">
		    <div class="col-3">
			<table class="side-table">
			  <tr><td>00</td></tr>
			  <tr><td>10</td></tr>
			  <tr><td>20</td></tr>
			  <tr><td>30</td></tr>
			  <tr><td>40</td></tr>
			  <tr><td>50</td></tr>
			  <tr><td>60</td></tr>
			  <tr><td>70</td></tr>
			  <tr><td>80</td></tr>
			  <tr><td>90</td></tr>
			</table>
		    </div>
		    <div class="col-6">
		      <div class="position-relative">
			<?php include('grille.php') ?>
			<img src="/img/Plan_salle_RDC.png" class="img-fluid" alt="Plan de la salle">
			<?php
			  foreach ($capteurs as $capteur) { ?>
			    <div class="position-absolute" style="top: <?php echo (int) $capteur['position_y'] ?>%; left: <?php echo (int) $capteur['position_x'] ?>%;">
			      <span class="d-inline-block" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-html="true">
				<button class="btn btn-success" type="button" disabled><?php echo $capteur['id_capteur'] ?></button>
			      </span>
			    </div>
			  <?php }
			?>
			<div class="position-absolute capteurTest" id="capteurTest" style="top: 0%; left: 0%;">
			  <span class="d-inline-block" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-html="true">
			    <button class="btn btn-danger" type="button" disabled>?</button>
			  </span>
			</div>
		      </div>
		    </div>
		  </div>
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
   $('.datepicker').datepicker({
      format: 'dd-mm-yyyy',
      language: 'fr'
    });
    
    function changePosition(pos) {
	if (pos == "x") {
	    var position = $('.inputPositionX').val();
	    if (Number(position) <= 0) {
		position = "0";
	    }
	    if (Number(position) >= 0 && Number(position) <= 92) {
		document.getElementById("capteurTest").style.left = position + '%';
	    }
	    if (Number(position) > 92 && Number(position) <= 100) {
		document.getElementById("capteurTest").style.left = '92%';
	    }
	}
	else if (pos == "y") {
	    var position = $('.inputPositionY').val();
	    if (Number(position) <= 0 ) {
		position = "0";
	    }
	    if (Number(position) >= 0 && Number(position) <= 92) {
		document.getElementById("capteurTest").style.top = position + '%';
	    }
	    if (Number(position) > 92 && Number(position) <= 100) {
		document.getElementById("capteurTest").style.top = '92%';
	    }
	}
    };
</script>
