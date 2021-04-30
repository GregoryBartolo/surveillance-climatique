<!DOCTYPE html>
<html>
 
  <head>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <?php include('sqlite_connection.php') ?>
    <?php include('data_index.php') ?>
  </head>
 
  <body>
    <?php include('navbar.php') ?>
    <div class="container-fluid">

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
                  <span class="d-inline-block" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-html="true" title="<a href='capteur.php?id_capteur=<?php echo $capteur['id_capteur'] ?>'>Informations Capteur n°<?php echo $capteur['id_capteur'] ?></a>" data-bs-content="<?php echo $capteur['content'] ?>">
                    <button class="btn btn-<?php echo $capteur['depassement']?>" type="button" disabled><?php echo $capteur['id_capteur'] ?></button>
                  </span>
                </div>
              <?php }
            ?>
          </div>
        </div>
      </div>

    </div>
  </body>
 
</html>

<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.min.js"></script>
<script type="text/Javascript">
  var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
  var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
    return new bootstrap.Popover(popoverTriggerEl);
  });
  
  $(function () {
    $('[data-toggle="popover"]').popover({
        container: 'body'
    });
  })
</script>
