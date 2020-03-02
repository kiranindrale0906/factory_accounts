<?php $action = $this->router->method; ?>
<?php $displayName = (isset($displayName) ? $displayName : 'SAVE');
$controller=$this->router->module."/".$this->router->class;
// print_r($data);
// exit;
?>
<?php if ($action != 'index'): ?>
  <hr>
<?php endif; ?>

<?php $is_ajax_request = (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) ? TRUE : FALSE; ?>
<?php $enter_method = (isset($record['id'])) ? '/update/'.$record['id'] : '/store'; ?>


<div class="boxrow">
  <?php if (!isset($data["show_inline_form"])): ?>
    <a href="<?= $is_ajax_request ? "#" : base_url($controller); ?>"
       class="btn btn-sm btn-link float-left">
       Back
    </a>
  <?php endif; ?>
  <button type="submit" 
          class="btn btn-sm btn_green float-right <?php echo !empty($data["class"])?$data["class"]:''; ?> <?= $is_ajax_request ? "ajax" : ""; ?>">
    Save
  </button>

</div>

<?php if ($action == 'index'): ?>
    <!--<hr>-->
<?php endif; ?>

<?php //if($is_ajax_request): 
?>
  <script>
    var urls = "<?= base_url($controller).$enter_method ?>";

  </script>
<?php 
//endif; 
?>
