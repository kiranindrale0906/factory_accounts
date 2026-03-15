<?php
  if (!isset($record)) 
    $record = array();

?>


<form method="post" class="form-horizontal fields-group-sm form_radius_none" enctype="multipart/form-data"
      action="<?= get_form_action($controller, $action, $record) ?>">
  <?php if ($action == 'edit' || $action == 'update'): ?>
    <?php load_field('hidden', array('field' => 'id')) ?>
  <?php endif; ?>     
   <?php load_field('hidden', 
             array('field' => 'company_id',
                   'value'=>(!empty($this->session->userdata('company_id'))?$this->session->userdata('company_id'):1))) ?>
    <?php load_field('text', array('field' => 'short_message')) ?>
    <?php load_field('text', array('field' => 'tvariable')) ?>
   
    <?php load_field('text', array('field' => 'type')) ?>
    <?php load_field('text', array('field' => 'company_code')) ?>
 
    <?php load_field('text', array('field' => 'message')) ?>
  
  <?php load_buttons('submit', array('controller' => $controller, 'name' => 'SAVE' , 'class' => 'btn_blue')) ?>
</form>