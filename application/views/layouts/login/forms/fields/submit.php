<?php @$data = get_field_data($data, $this->router, $record); ?>
<?php $displayName = (isset($displayName) ? $displayName : 'SAVE');
?>
<?php if ($action != 'index'): ?>
  <hr>
<?php endif; ?>

<?php $is_ajax_request = (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) ? TRUE : FALSE; ?>
<?php $enter_method = (isset($record['id'])) ? '/update/'.$record['id'] : '/store'; ?>

<div class="boxrow">  
  <button type="submit" class="btn btn-md btn_blue d-block mx-auto mt-2 <?= $is_ajax_request ? "ajax" : ""; ?>">
    Login
  </button>
</div>

<?php if ($action == 'index'): ?>
    <!--<hr>-->
<?php endif; ?>

<?php if($is_ajax_request): ?>
  <script>
    $('button.ajax').on('click', function(e) {
      e.preventDefault();
      store_entry("<?= base_url($controller).$enter_method ?>");
      return false;
    });
  </script>
<?php endif; ?>
