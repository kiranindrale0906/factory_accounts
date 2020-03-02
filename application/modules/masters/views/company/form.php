<?php
  if (!isset($record)) 
    $record = array();

?>
<form method="post" class="form-horizontal fields-group-sm form_radius_none" enctype="multipart/form-data"
      action="<?= get_form_action($controller, $action, $record) ?>">
  <?php if ($action == 'edit' || $action == 'update'): ?>
    <?php load_field('hidden', array('field' => 'id')) ?>
  <?php endif; ?>     
  <div class="row">    
    <?php load_field('text', array('field' => 'name')) ?>
    <?php load_field('text', array('field' => 'address_line1')) ?>
  </div>
  <div class="row">    
    <?php load_field('text', array('field' => 'address_line2')) ?>
    <?php load_field('text', array('field' => 'city')) ?>
  </div>
  <div class="row">    
    <?php load_field('text', array('field' => 'state')) ?>
    <?php load_field('text', array('field' => 'pincode')) ?>
  </div>
  <div class="row">    
    <?php load_field('file', array('field' => 'logo')) ?>
  </div>
  <?php load_buttons('submit', array('controller' => $controller, 'name' => 'SAVE' , 'class' => 'btn_blue')); ?>
</form>