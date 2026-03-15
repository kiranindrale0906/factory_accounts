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
        load_field('text', array('field' => 'account_name',
                             'class' => 'autocomplete_list_selection',
                             'data-table'=>'ac_account',
                             'data-column'=>'name',
                             'data-list-title'=>'Account Name')); ?>
  </div>
  <div class="row">    
    <?php 
        load_field('dropdown', array('field' => 'site_name','option'=>array(
          array('id'=>'AR Gold','name'=>'AR Gold'),
          array('id'=>'ARF','name'=>'ARF'),
          array('id'=>'ARC','name'=>'ARC')))); ?>
  </div>
  <div class="row">      

    <?php  
      // load_field('text', array('field' => 'purity')); 
      // load_field('text', array('field' => 'factory_purity')); 
      // load_field('text', array('field' => 'fine')); 
      load_field('text', array('field' => 'item_code')); 

      if(in_array($record['voucher_type'], array('cash receipt voucher','cash issue voucher'))){
        load_field('text', array('field' => 'taxable_amount')); 
        load_field('text', array('field' => 'cgst_amount'));  
      }?>
  </div>
  <div class="row">        
    <?php    if(in_array($record['voucher_type'], array('cash receipt voucher','cash issue voucher'))){
          load_field('text', array('field' => 'sgst_amount')); 
          load_field('text', array('field' => 'tcs_amount')); 
        }?>
  </div>
  <div class="row">        
    <?php    load_field('date',array('field' => 'voucher_date',
                                  'value'=>(!empty($record['voucher_date'])?date('d-m-Y',strtotime($record['voucher_date'])):date('d-m-Y')), 
                                  'class' => 'datepicker_js'));
        load_field('checkbox',
                  array('field'=>'is_export',
                        'check_inline'=>true,
                        'option'=> array(
                                    array('label_for' => 'Is Export',
                                          'label'=> 'Is Export',
                                          'value' =>'1',))));?>
  </div>
  <?php load_buttons('submit', array('controller' => $controller, 'name' => 'SAVE' , 'class' => 'btn_blue')) ?>
</form>
