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
    <?php load_field('dropdown', array('field' => 'account_name_id',
                                              'option'=>@$account_name,
                                              'value'=>@$record['account_name_id'])) ?>
  </div>
  <div class="row">    
    <?php load_field('dropdown', array('field' => 'group_code',
                                              'option'=>@$groups,
                                              'value'=>@$record['group_code'])) ?>
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
    <?php load_field('dropdown', array('field' => 'cash_bill_type',
                                              'option'=>@$cashbilltype,
                                              'value'=>@$record['cash_bill_type'])) ?>
    <?php load_field('text', array('field' => 'gst_number')) ?>
  </div>
  <?php load_field('submit', array('controller' => $controller)) ?>
</form>