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
    <?php load_field('date', array('field' => 'date','value'=>date('d-m-Y'), 'class' => 'datepicker_js')) ?>
    <?php load_field('text', array('field' => 'account_name',
                                    'class' => 'autocomplete_list_selection',
                                     'data-table'=>'ac_account',
                                     'data-column'=>'name',
                                     'data-where_condition'=>'group_code!=\'bank\'',
                                     'data-list-title'=>'Account Name')) ?>
  </div>
  <div class="row">    
    <?php load_field('text', array('field' => 'group_code',
                                     'class' => 'autocomplete_list_selection',
                                     'data-table'=>'ac_groups',
                                     'data-column'=>'name',
                                     'data-list-title'=>'Group')) ?>
    <?php load_field('text', array('field' => 'credit_amount')) ?>
  </div>
  <div class="row">    
    <?php load_field('text', array('field' => 'debit_amount')) ?>
    <?php load_field('text', array('field' => 'credit_weight')) ?>
  </div>
  <div class="row">    
    <?php load_field('text', array('field' => 'debit_weight')) ?>
    <?php load_field('text', array('field' => 'narration')) ?>
  </div>
  <div class="row">    
    <?php load_field('text', array('field' => 'cash_bill_type',
                                     'class' => 'autocomplete_list_selection',
                                     'data-table'=>'ac_cash_bill',
                                     'data-column'=>'name',
                                     'data-list-title'=>'Cash / Bill')) ?>
    <?php load_field('text', array('field' => 'gst_number')) ?>
  </div>
  <?php load_buttons('submit', array('controller' => $controller, 'name' => 'SAVE' , 'class' => 'btn_blue')) ?>
</form>