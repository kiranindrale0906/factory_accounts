<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta http-equiv='cache-control' content='no-cache'>
    <meta http-equiv='expires' content='0'>
    <meta http-equiv='pragma' content='no-cache'>
    <link rel="icon" type="image/png" sizes="16x16" href="<?= BASE_URL ?>assets/core/images/common/favicon.ico">
    <link rel="manifest" href="manifest.json">
    <?php 
      $this->load->view('layouts/theme/css');
    ?> 
</head>

<body>
  <main>
    <div class="main_wrapper">     
      <div class="wrapper_container">
        <div class="card card-default">
          <div class="card-body">
            <?php
              if (isset($view)):
                $this->load->view($view);
              endif;
            ?>    
          </div>
        </div>      
      </div>
      <!-- <footer class="footer"> © 2019</footer> -->
    </div>
  </main>

  
  
</body>
</html>