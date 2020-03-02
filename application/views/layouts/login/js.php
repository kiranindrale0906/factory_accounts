<?php 
  if(!PAGES_MINIFY){
    foreach (LOGIN_JS() as $js) {?>
      <script src="<?=$js?>"></script>
  <?php } }
  else{  ?>
    <script src="<?=LAYOUT_PATH('login');?>minified/login-<?=JS_CSS_TIMESTAMP?>.js"></script>
  <?php }?>

<script type="text/javascript">var base_url = '<?= BASE_URL?>'; </script>


