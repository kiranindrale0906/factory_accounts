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
    <?php load_field('text', array('field' => 'name')) ?>
    <?php load_field('text', array('field' => 'unrecoverable_account_name',
                             'class' => 'autocomplete_list_selection',
                             'data-table'=>'ac_account',
                             'data-column'=>'name',
                             'data-where_condition'=>'group_code!=\'bank\'',
                             'data-list-title'=>'Account Name')); ?>

   </div>
  <div class="row"> 
     <?php load_field('text', array('field' => 'sub_group_code', 
                               'data-table'=>'ac_sub_groups',
                               'class' => 'autocomplete_list_selection',
                               'data-column'=>'name',
                               'data-list-title'=>'Sub Group Name')); ?>
  
  </div>   
  <div class="row">    
    <?php //load_field('dropdown', array('field' => 'payment_terms',
                                           // 'option'=>@$payment_terms,
                                           // 'value'=>@$record['payment_terms'])); ?>
    <?php //load_field('text', array('field' => 'cont_person')) ?>
  </div>
  <div class="row">    
    <?php //load_field('text', array('field' => 'off_tel')); ?>
    <?php /*load_field('text', array('field' => 'city',
                                   'class' => 'autocomplete_list_selection',
                                   'data-table'=>'ac_city',
                                   'data-column'=>'name',
                                   'data-list-title'=>'City'));*/ ?>
  </div>
  <div class="row">    
    <?php /*load_field('text', array('field' => 'state',
                                   'class' => 'autocomplete_list_selection',
                                   'data-table'=>'ac_state',
                                   'data-column'=>'name',
                                   'data-list-title'=>'States'));*/ ?>
    <?php /*load_field('text', array('field' => 'salesman_code',
                                   'class' => 'autocomplete_list_selection',
                                   'data-table'=>'ac_salesman',
                                   'data-column'=>'salesman_code',
                                   'data-list-title'=>'Salesman Code'));*/ ?>
  </div>
  <div class="row">    
    <?php //load_field('text', array('field' => 'address')); ?>
    <?php //load_field('text', array('field' => 'pin')); ?>
  </div>
  <div class="row">    
    <?php /*load_field('text', array('field' => 'area',
                                  'class' => 'autocomplete_list_selection',
                                   'data-table'=>'ac_account_wise_details',
                                   'data-column'=>'area',
                                   'data-list-title'=>'Area'));*/ ?>
    <?php //load_field('text', array('field' => 'res_tel')); ?>
  </div>
  <div class="row">    
    <?php //load_field('text', array('field' => 'coll_days')); ?>
    <?php //load_field('text', array('field' => 'cr_days')); ?>
  </div>
  <div class="row">    
    <?php //load_field('text', array('field' => 'interest_rate')); ?>
    <?php //load_field('text', array('field' => 'salary')) ?>
  </div>
  <div class="row">    
    <?php //load_field('text', array('field' => 'email')); ?>
    <?php //load_field('text', array('field' => 'web_address')); ?>
  </div>
  <div class="row">    
    <?php //load_field('text', array('field' => 'cst_no')); ?>
    <?php //load_field('text', array('field' => 'mvat_lst_no')); ?>
  </div>
  <div class="row">    
    <?php //load_field('text', array('field' => 'pan_no')); ?>
    <?php //load_field('text', array('field' => 'srv_tax_no')); ?>
  </div>
  <div class="row">    
    <?php //load_field('text', array('field' => 'sms_mobile_no')) ?>
    <?php //load_field('text', array('field' => 'fine_wt_limit')) ?>
  </div>
  <div class="row">    
    <?php //load_field('text', array('field' => 'remark')); ?>
  </div> 

  <?php load_buttons('submit', array('controller' => $controller, 'name' => 'SAVE' , 'class' => 'btn_blue')) ?>
</form>
