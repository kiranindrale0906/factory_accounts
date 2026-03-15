<?php
  if (!isset($record)) 
    $record = array();
?>
<form method="post" class="form-horizontal fields-group-sm form_radius_none" enctype="multipart/form-data"
      action="<?= get_form_action($controller, $action, $record) ?>">
  <?php if ($action == 'edit' || $action == 'update'): ?>
    <?php load_field('hidden', array('field' => 'id')); ?>
    <?php load_field('text', array('field' => 'sr_no')); ?>
    <?php load_field('text', array('field' => 'gross_weight')); ?>
    <?php load_field('text', array('field' => 'stone')); ?>
    <?php load_field('text', array('field' => 'making_charge')); ?>
    <?php load_field('text', array('field' => 'quantity')); ?>
    <?php load_field('dropdown', array('field' => 'category_name','option'=>array(array('id'=>'-','name'=>'-'),
                                        array('id'=>'CZ','name'=>'CZ'),
                                        array('id'=>'Meena','name'=>'Meena'),
                                        array('id'=>'Pearls','name'=>'Pearls'),
                                        array('id'=>'Plastic','name'=>'Plastic'),
                                        array('id'=>'Rudraksh','name'=>'Rudraksh')))); ?>
    <?php load_field('dropdown', array('field' => 'category_2','option'=>array(array('id'=>'-','name'=>'-'),
                                        array('id'=>'CZ','name'=>'CZ'),
                                        array('id'=>'Meena','name'=>'Meena'),
                                        array('id'=>'Pearls','name'=>'Pearls'),
                                        array('id'=>'Plastic','name'=>'Plastic'),
                                        array('id'=>'Rudraksh','name'=>'Rudraksh')))); ?>
    <?php load_field('text', array('field' => 'code')); ?>
    <?php load_field('text', array('field' => 'description')); ?>
    <?php load_field('text', array('field' => 'colour')); ?>
  <?php endif; ?>     
    <?php load_buttons('submit', array('controller' => $controller, 'name' => 'SAVE' , 'class' => 'btn_blue')) ;
    echo validation_errors();
  ?>

</form>
