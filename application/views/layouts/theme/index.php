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

<body class="thm_blue expand_sidemenu <?= @$_SESSION['mini_sidebar'] ?>" data-url = <?php echo base_url();?>>
<input type="hidden" id="base_url" value="<?php echo base_url() ?>"> 
  <main>
    <?php $this->load->view('navigation/theme/header'); ?>
    <?php $this->load->view('navigation/theme/sidebar'); ?>
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

  <input type="hidden" name="<?php echo get_csrf_token()['name']?>" value="<?php echo get_csrf_token()['hash'];?>" id="csrf_token">
  
  <?php $this->load->view('layouts/application/modals/index'); ?>

  <script type="text/javascript">
    //  var firebaseConfig = {
    //   apiKey: "<?php echo APIKEY; ?>",
    //   authDomain: "<?php echo AUTHDOMAIN; ?>",
    //   databaseURL: "<?php echo DATABASEURL; ?>",
    //   projectId: "<?php echo PROJECTID; ?>",
    //   storageBucket: "<?php echo STORAGEBUCKET; ?>",
    //   messagingSenderId: "<?php echo MESSAGINGSENDERID; ?>",
    //   appId: "<?php echo APPID; ?>",
    //   measurementId: "<?php echo MEASUREMENTID; ?>"
    // };
  </script>
  <?php $this->load->view('layouts/theme/js'); ?>  
  <script >
    var url = '<?php echo base_url().$this->router->
                      fetch_module().'/'.$this->router->fetch_class().'/';?>';
    var tooltips = <?=(isset($tooltips) && ($tooltips !='NULL' || $tooltips !=NULL))?get_tooltips_json($tooltips):2; ?>;
    var module_name = "<?php echo $this->router->fetch_module();?>";
  </script>
  <div class="ajaxloader onclick_ajaxloader_js"></div>
  <div class="overlaybg_js"></div>
</body>
</html>