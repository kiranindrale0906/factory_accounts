<?php 
  if(!PAGES_MINIFY){
  	foreach (THEME_JS() as $js) {?>
      <script src="<?=$js?>"></script>
  	<?php } 
  }
  else{  ?>
    <script src="<?=LAYOUT_PATH();?>minified/application-<?=JS_CSS_TIMESTAMP?>.js"></script>
  <?php }?>

