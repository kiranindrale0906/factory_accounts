<form method="post" class="form-horizontal fields-group-sm form_radius_none" enctype="multipart/form-data"
  action="<?= get_form_action($controller, $action, $record) ?>">
  <div class="row"> 
    <?php load_field('text', array('field' => 'verify_code')) ?>
    <?php load_buttons('button', array('name'=>'Verify Mobile','class'=>'btn_green send_sms','type'=>'button')) ?>
  </div>
  <?php load_buttons('submit', array('controller' => $controller,'name'=>'Submit','class'=>'btn_blue')) ?>
</form>