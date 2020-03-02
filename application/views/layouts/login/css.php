 <?php 
 	if(!PAGES_MINIFY){
    foreach (LOGIN_CSS() as $css) {?>
      <link rel="stylesheet" href="<?=$css?>"><?php
    } 
  }else{ ?>
    <link rel="stylesheet" href="<?=LAYOUT_PATH('login');?>minified/login-<?=JS_CSS_TIMESTAMP?>.css"> 
<?php }?>