<?php

$query = "SELECT DISTINCT id_capteur, position_x, position_y from capteurs";
$capteurs = $dbh->query($query)->fetchAll();
