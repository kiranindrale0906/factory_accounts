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
    <link rel="icon" type="image/png" sizes="16x16" href="<?= LOGIN_PATH() ?>favicon.ico">    
    <?php $this->load->view('layouts/login/css'); ?>  
</head>

<body class="">  
  <input type="hidden" id="base_url" value="<?php echo base_url() ?>">
  <?php if($this->router->method == 'index'):
    $page_details = getTableSettings();
  endif; ?> 

  <main class="login">
    <div class="login_wrapper">
      <div class="logo_div">
        <img src="<?= LOGIN_PATH() ?>images/common/logo.png" class="img-fluid">
      </div>     
      <div class="card">
        <div class="card-body">
          <?php
            if (isset($view)):
              $this->load->view($view);                  
            endif;
          ?>    
        </div>
      </div>      
      </div>      
  </main>

  <?php $this->load->view('layouts/login/js'); ?>
  
  <script >
    var url = '<?php echo base_url().$this->router->fetch_module().'/'.$this->router->fetch_class().'/';?>';
  </script>
</body>
</html>