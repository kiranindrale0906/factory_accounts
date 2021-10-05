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
    <?php 
      load_field('text', array('field' => 'gold_rate')); 
      load_field('dropdown', array('field' => 'gold_rate_purity', 'option' => get_gold_rate_purities())); ?>
  </div>
  <?php    if(in_array($record['voucher_type'], array('metal receipt voucher'))){?>
  <div class="row">        
    <?php  load_field('dropdown', array('field' => 'sale_type', 'option' => get_sale_types())); 
      load_field('plain/checkbox',
                  array('field'=>'is_export',
                        'check_inline'=>true,
                        'option'=> array(
                                    array('label_for' => 'Import',
                                          'label'=> 'Import',
                                          'value' =>'1',))));
    ?>
  </div>
<?php }?>

<div class="row"> 
        <?php 
        load_field('checkbox',
                    array('field'=>'do_not_calculate_tax',
                          'check_inline'=>true,
                          'option'=> array(
                                      array('label_for' => 'Do Not Calculate Tax',
                                            'label'=> 'Do Not Calculate Tax',
                                            'value' =>'1',))));
      ?>
   
  </div>

  <?php load_buttons('submit', array('controller' => $controller, 'name' => 'SAVE' , 'class' => 'btn_blue')) ?>
</form>
