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
    <?php load_field('dropdown', array('field' => 'site_name',
                                       'option' => $site_names,
                                       'value' => $record['site_name']));?>
    <?php load_field('dropdown', array('field' => 'account_name','option'=>$account_name));?>
    <?php load_field('dropdown', array('field' => 'purity',
                                       'option'=>$purity));?>
    <?php load_field('date',array('field' => 'date','class'=>'datepicker_js')); ?>
    <?php load_field('text',array('field' => 'no_of_packets'));  ?>
    <?php load_field('text',array('field' => 'packet_gross_weight'));  ?>
    <?php load_field('text',array('field' => 'manual_taxable_amount'));  ?>
    <?php load_field('text',array('field' => 'stone_amount'));  ?>
    
    <?php load_field('dropdown', array('field' => 'sale_type',
                                       'option'=> array(array('id' => 'Sale', 'name' => 'Sale'),
                                                        array('id' => 'Labour', 'name' => 'Labour'))));?>
    <?php load_field('text',array('field' => 'rate'));  ?>
    <?php load_field('text',array('field' => 'product_rate'));  ?>
    <?php load_field('text',array('field' => 'hallmark_quantity'));?>
    <?php load_field('text',array('field' => 'hallmark_rate'));  ?>
    <?php load_field('text',array('field' => 'empty_packet_weight'));  ?>
    <?php load_field('text',array('field' => 'actual_weight'));  ?>

    <?php
      if($this->router->class == 'chitti_exports'){?>
      <?php load_field('text',array('field' => 'ounce_rate'));  ?>
      <?php load_field('text',array('field' => 'usd_rate'));  ?>
      <?php //load_field('text',array('field' => 'premium_rate'));  ?>
      <?php load_field('text',array('field' => 'premium_usd_amount'));  ?>
      <?php //load_field('text',array('field' => 'labour_rate'));  ?>
      <?php load_field('text',array('field' => 'labour_usd_amount'));  ?>
      <?php load_field('text',array('field' => 'freight_usd_amount'));  
    } ?>
    
  </div>
    <?php $this->load->view('chitti_details/formlist');?>
  <?php load_buttons('submit', array('controller' => $controller, 'name' => 'SAVE' , 'class' => 'btn_blue')) ;
    echo validation_errors();
  ?>

</form>
