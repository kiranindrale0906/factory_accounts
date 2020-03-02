<?php if(!empty(form_error(@$data['name']))): ?>
  <div class="clear red font12" id="<?= @$data['name'] ?>_error">
    <?php echo form_error(@$data['name']); ?>
  </div>
<?php endif ?>