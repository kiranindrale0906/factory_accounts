<?php
  if (!isset($record)) {
    $record = array();
  }
?>
<?php echo form_open_multipart(get_form_action($controller, $action, $record))?>
  <div class="row">
    <?php if ($action == 'edit' || $action == 'update'): ?>
      <?php load_field('hidden', array('field' => 'id')) ?>
    <?php endif; ?>
    <?php load_field('text', array('field' => 'name')) ?>
  </div>

  <?php $this->load->view('users/user_role_permissions/form', array(
                                    'user_role_permissions' => $user_role_permissions)); ?>

  <?php load_buttons('submit', array('controller' => $controller,'name'=>'Submit','class'=>'btn_blue')) ?>
</form>
<?php echo form_close()?>
