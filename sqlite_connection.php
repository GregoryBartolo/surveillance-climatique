<?php
try {
        $dir = 'sqlite:surveillance_climatique.db';
        $dbh = new PDO($dir) or die("cannot open the database");
} catch(Exception $e) {
    echo "Probleme de connexion à la base de données";
    echo $e->getMessage();
}

 
