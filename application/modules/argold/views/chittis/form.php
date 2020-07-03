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
    <?php load_field('text', array('field' => 'account_name',
                             'class' => 'autocomplete_list_selection',
                             'data-table'=>'ac_account',
                             'data-column'=>'name',
                             'data-list-title'=>'Account Name'));?>
    <?php load_field('dropdown', array('field' => 'purity',
                             'option'=>$purity));?>
    <?php load_field('date',array('field' => 'date',
                            'value' => (!empty($record['voucher_date']) ? date('d M Y', strtotime($record['date'])) : date('d M Y')), 
                            'readonlyinput' => true));  ?>
  </div>
    <?php $this->load->view('chitti_details/formlist');?>
  <?php load_buttons('submit', array('controller' => $controller, 'name' => 'SAVE' , 'class' => 'btn_blue')) ?>
</form>
