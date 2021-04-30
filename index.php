<!DOCTYPE html>
<html>
 
  <head>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <?php include('sqlite_connection.php') ?>
    <?php include('data_index.php') ?>

  </head>
 
  <body>
    <div class="container-fluid">

    <?php include('navbar.php') ?>
    <div class="mt-3 row justify-content-center">
      <div class="col-6">
        <div class="position-relative">
          <img src="/img/Plan_salle_RDC.png" class="img-fluid" alt="Plan de la salle">
          <div class="position-absolute top-50 start-50">
            <span class="d-inline-block" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-html="true" title="<a href='capteur.php?id_capteur=<?php echo $id_capteur ?>'>Informations Capteur n°<?php echo $id_capteur ?></a>" data-bs-content="<?php echo $infos_capteur ?>">
              <button class="btn btn-primary" type="button" disabled><?php echo $id_capteur ?></button>
            </span>
          </div>
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
