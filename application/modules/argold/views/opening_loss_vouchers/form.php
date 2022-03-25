<?php
  if (!isset($record)) 
    $record = array();

?>
<form method="post" class="form-horizontal fields-group-sm form_radius_none" enctype="multipart/form-data"
      action="<?= get_form_action($controller, $action, $record) ?>">
  <?php
   if ($action == 'edit' || $action == 'update'): ?>
    <?php load_field('hidden', array('field' => 'id')) ?>
     <?php endif; ?>     
  <div class="row">    
     <?php load_field('date',array('field' => 'date','class'=>'datepicker_js','value'=>(!empty($record['date'])?date('d-m-Y',strtotime($record['date'])):date('d-m-Y')), )); ?>
    <?php load_field('dropdown', array('field' => 'factory_name',
                                      'option'=>array(
                                        array('id'=>'AR Gold','name'=>'AR Gold'),array('id'=>'ARF','name'=>'ARF'),array('id'=>'ARC','name'=>'ARC')))) ?>
    <?php load_field('text', array('field' => 'type_of_loss')) ?>
    <?php load_field('text', array('field' => 'loss')) ?>
    <?php load_field('text', array('field' => 'out_weight')) ?>
    <?php load_field('text', array('field' => 'purity')) ?>
    <?php load_field('text', array('field' => 'after_recovered')) ?>
    <?php load_field('text', array('field' => 'recovered_loss')) ?>
    <?php load_field('text', array('field' => 'unrecovered_loss')) ?>
  </div>
  <?php load_buttons('submit', array('controller' => $controller, 'name' => 'SAVE' , 'class' => 'btn_blue')); ?>
</form>