<?php
	$query = "SELECT id_capteur FROM capteurs";
	$stations = $dbh->query($query)->fetchAll();
?>

<nav class="navbar navbar-dark bg-primary">
	<div class="container-fluid">
	  <a class="navbar-brand" href="index.php">Salle de surveillance climatique</a>
	  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	  </button>
	  <div class="collapse navbar-collapse" id="navbarNavDropdown">
		<ul class="navbar-nav">
		  <li class="nav-item">
			<a class="nav-link" href="ajout_station.php">Ajouter une station</a>
		  </li>
		  <li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
			  Modifier une station
			</a>
			<ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
			  <?php
				foreach ($stations as $value) { ?>
				  <li><a class="dropdown-item" href="capteur.php?id_capteur=<?php echo $value[0] ?>">Station <?php echo $value[0] ?></a></li>
				<?php }
			  ?>
			</ul>
		  </li>
		</ul>
	  </div>
	</div>
</nav>
