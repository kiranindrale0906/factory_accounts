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
  </div>
  <div class="row">    
    <?php load_field('date',array('field' => 'date_from',
                                      'class' => 'datepicker_js')) ?>
  </div>
  <div class="row">    
    <?php load_field('date',array('field' => 'date_to',
                                      'class' => 'datepicker_js')) ?>
  </div>
  <?php $add_attr=array('controller' => $controller, 'name' => 'SAVE' , 'class' => 'btn_blue');
          load_buttons('submit', $add_attr);  ?>
</form>