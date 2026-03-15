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
    <?php load_field('text', array('field' => 'percentage')) ?>
  </div>
  <?php load_field('submit', array('controller' => $controller)) ?>
</form>