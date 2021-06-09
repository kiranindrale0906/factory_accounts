<?php
  if (!isset($record)) 
    $record = array();
?>
<form method="post" class="form-horizontal fields-group-sm form_radius_none" enctype="multipart/form-data"
      action="<?= get_form_action($controller, $action, $record) ?>">
  <?php if ($action == 'edit' || $action == 'update'): ?>
    <?php load_field('hidden', array('field' => 'id')); ?>
  <?php endif; ?>     
  <div class="row">    
    <?php load_field('text', array('field' => 'site_name', 'readonly' => true));?>
    <?php load_field('dropdown', array('field' => 'account_name','option'=>$account_name));?>
    <?php load_field('text', array('field' => 'purity', 'readonly' => true));?>
    <?php load_field('date',array('field' => 'date','class'=>'datepicker_js','value'=>(!empty($record['date'])?date('d-m-Y',strtotime($record['date'])):date('d-m-Y')), )); ?>
    <?php load_field('text',array('field' => 'no_of_packets'));  ?>
    <?php load_field('text',array('field' => 'packet_gross_weight'));  ?>
    <?php load_field('text',array('field' => 'manual_taxable_amount'));  ?>
    <?php load_field('text',array('field' => 'stone_amount'));  ?>

    <?php load_field('dropdown', array('field' => 'sale_type',
                                       'option'=> array(array('id' => 'Sale', 'name' => 'Sale'),
                                                        array('id' => 'Labour', 'name' => 'Labour'))));?>
    <?php load_field('text',array('field' => 'rate'));  ?>

    <?php
      if($this->router->class == 'chitti_exports'){ ?>
    <?php load_field('text',array('field' => 'ounce_rate'));  ?>
    <?php load_field('text',array('field' => 'usd_rate'));  ?>
    <?php //load_field('text',array('field' => 'premium_rate'));  ?>
    <?php load_field('text',array('field' => 'premium_usd_amount'));  ?>
    <?php //load_field('text',array('field' => 'labour_rate'));  ?>
    <?php load_field('text',array('field' => 'labour_usd_amount'));  ?>
    <?php load_field('text',array('field' => 'freight_usd_amount'));  } ?>
    
    <?php //load_field('text',array('field' => 'taxable_amount'));  ?>
  </div>
  <?php load_buttons('submit', array('controller' => $controller, 'name' => 'SAVE' , 'class' => 'btn_blue')) ;
    echo validation_errors();
  ?>

</form>
