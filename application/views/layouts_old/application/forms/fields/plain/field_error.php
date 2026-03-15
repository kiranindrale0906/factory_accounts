<?php if(!empty(form_error($data['data']['name']))): ?>
  <div class="col-md-3"></div>
  <div class="clear red font12 col-md-9" id="<?= $data['data']['name'] ?>_error">
    <?php echo form_error($data['data']['name']); ?>
  </div>
<?php endif ?>