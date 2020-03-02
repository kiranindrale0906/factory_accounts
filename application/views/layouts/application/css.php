 <?php 
 	if(!PAGES_MINIFY){
    foreach (APPLICATION_CSS() as $css) {?>
      <link rel="stylesheet" href="<?=$css?>"><?php   
		} 
  }else{ ?>
    <link rel="stylesheet" href="<?=LAYOUT_PATH();?>minified/application-<?=JS_CSS_TIMESTAMP?>.css"> 
<?php }?>