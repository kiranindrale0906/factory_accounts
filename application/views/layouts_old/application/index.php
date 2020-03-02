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
    <link rel="icon" type="image/png" sizes="16x16" href="<?= ADMIN_IMAGES_PATH ?>favicon.ico">
    
    <?php $this->load->view('layouts/application/css'); ?>  
</head>

<body class="thm_black expand_sidemenu <?= @$_SESSION['mini_sidebar'] ?>">  
  <input type="hidden" id="base_url" value="<?php echo base_url() ?>">

  <?php 
    $page_details = getTableSettings();
  ?>

  <main>
    <?php $this->load->view('layouts/application/navigation/headnav'); ?>
    <?php $this->load->view('layouts/application/navigation/sidenav'); ?>
    <div class="main_wrapper">
    <div class="col-12">
      <h6 class="heading blue text-uppercase pt-3 mb-0"><?= $page_details['page_title']; ?></h6>
    </div>    
     <!--  <div class="boxrow pagetitle sticky_head">
        <div class="float-left">
          <a href="<?= ADMIN_PATH ?>">
            <img src="https://via.placeholder.com/200x50.png" height="40px" alt="user" class="dark-logo">
          </a>    
        </div>
        <div class="float-left">
          <h5 class="heading text-capitalize"><?= $page_details['page_title']; ?></h5>
        </div>
        <div class="float-right">
          <p class="medium m-0">Last Sync At : 06/01/19 04:27:36 AM <a href="">Refresh</a></p>
        </div>
      </div> -->
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
      <footer class="footer"> © 2019 Faber Lounge Accounting</footer>
    </div>
  </main>

  <?php $this->load->view('layouts/application/modals/index'); ?>
  <?php $this->load->view('layouts/application/js'); ?>
  
  <script >
    var url = '<?php echo base_url().$this->router->fetch_module().'/'.$this->router->fetch_class().'/';?>';
  </script>
</body>
</html>