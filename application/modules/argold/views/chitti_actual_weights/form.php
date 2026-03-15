<?php
  if (!isset($record)) 
    $record = array();
?>
<form method="post" class="form-horizontal fields-group-sm form_radius_none" enctype="multipart/form-data"
      action="<?= get_form_action($controller, $action, $record) ?>">
  <?php if ($action == 'edit' || $action == 'update'): ?>
    <?php load_field('hidden', array('field' => 'id')); ?>
    <?php load_field('hidden', array('field' => 'actual_weight_factory','name'=>'actual_weight_factory' ,'value'=>$_GET['factory'])); ?>
  <?php endif; ?>     
  <div class="row">    
    <?php 
        load_field('text', array('field' => 'actual_weight')); ?>
  </div>
  
  <?php load_buttons('submit', array('controller' => $controller, 'name' => 'SAVE' , 'class' => 'btn_blue')) ?>
</form>
