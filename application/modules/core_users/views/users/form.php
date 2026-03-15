<!-- <form method="post" class="form-horizontal fields-group-sm form_radius_none" enctype="multipart/form-data"
  action="<?= get_form_action($controller, $action, $record) ?>"> -->
<?= form_open(get_form_action($controller, $action, $record));?>
  <?php if ($action == 'edit' || $action == 'update'): ?>
    <?php load_field('hidden', array('field' => 'id')) ?>
  <?php endif; ?>     
  <div class="row"> 
    <?php load_field('text', array('field' => 'name'/*, 'horizontal'=>true*/)) ?>
    <?php load_field('text', array('field' => 'mobile_no')) ?>
    <?php load_field('text', array('field' => 'email_id')) ?>
    <?php if ($action == 'create' || $action == 'store'): ?>
      <?php load_field('password', array('field' => 'password')) ?>
      <?php load_field('password', array('field' => 'confirm_password', 'name' => 'confirm_password')) ?>
    <?php endif;?>
    <?php
     // $arg_details = (!empty($record['arg_details'])) ? 'checked' : '';
     // $arf_details = (!empty($record['arf_details'])) ? 'checked' : '';
     // $arc_details = (!empty($record['arc_details'])) ? 'checked' : '';
     // $vodator_report = (!empty($record['vodator_report'])) ? 'checked' : '';
     // $production_report = (!empty($record['production_report'])) ? 'checked' : '';
    ?>

     
  </div> 
    <div>
     <?php  load_field('plain/checkbox',
                  array('field'=>'all_details',
                        'check_inline'=>true,
                        'option'=> array(
                                    array('label_for' => 'All Details',
                                          'label'=> 'All Details',
                                          'value' =>'1',))));?>
    <?php  load_field('plain/checkbox',
                  array('field'=>'arg_details',
                        'check_inline'=>true,
                        'option'=> array(
                                    array('label_for' => 'ARG Details',
                                          'label'=> 'ARG Details',
                                          'value' =>'1',))));?>
     <?php  load_field('plain/checkbox',
                  array('field'=>'arf_details',
                        'check_inline'=>true,
                        'option'=> array(
                                    array('label_for' => 'ARF Details',
                                          'label'=> 'ARF Details',
                                          'value' =>'1',))));?>
     <?php  load_field('plain/checkbox',
                  array('field'=>'arc_details',
                        'check_inline'=>true,
                        'option'=> array(
                                    array('label_for' => 'ARC Details',
                                          'label'=> 'ARC Details',
                                          'value' =>'1',))));?>
     <?php  load_field('plain/checkbox',
                  array('field'=>'vodator_report',
                        'check_inline'=>true,
                        'option'=> array(
                                    array('label_for' => 'Vodator Report',
                                          'label'=> 'Vodator Report',
                                          'value' =>'1',))));?>
      <?php  load_field('plain/checkbox',
                  array('field'=>'gross_profit_report',
                        'check_inline'=>true,
                        'option'=> array(
                                    array('label_for' => 'Gross Profit Report',
                                          'label'=> 'Gross Profit Report',
                                          'value' =>'1',))));?>
     <?php  load_field('plain/checkbox',
                  array('field'=>'production_report',
                        'check_inline'=>true,
                        'option'=> array(
                                    array('label_for' => 'Production Report',
                                          'label'=> 'Production Report',
                                          'value' =>'1',))));?>
   <?php  load_field('plain/checkbox',
                  array('field'=>'do_not_check_ip',
                        'check_inline'=>true,
                        'option'=> array(
                                    array('label_for' => 'Do Not Check IP',
                                          'label'=> 'Do Not Check IP',
                                          'value' =>'1',))));?>
    </div>                                      

  <h5>Roles <span class="red">*</span></h5>   
  <?php foreach($user_role_options as $user_role):?>
    <div class="row">    
      <div class="col-md-1">
        <?php load_field('checkbox', 
                          array('name' => 'users_user_roles[user_role_id][]',
                                'controller' => 'users_user_roles',
                                'field' => 'users_user_roles',
                                'value' => (isset($users_user_role_ids) 
                                            && in_array($user_role['id'], $users_user_role_ids)) ? $user_role['id'] : '',
                                'option' => array( array('label' => $user_role['name'],
                                                         'value' => $user_role['id'],
                                                         'checked' => ((isset($users_user_role_ids) 
                                                    && in_array($user_role['id'], $users_user_role_ids)) /*|| empty($users_user_role_ids)*/) ? 'checked' : '',)))) ?>
      </div>                                           
      <div class="col-md-2">
         <?php 
              load_buttons('anchor', 
                                array(
                                   'name'=> 'link',
                                   'data-title' => 'Permissions',
                                   'class'=>'btn-sm blue premissions_users ajax', 
                                   'href' => base_url()."users/user_roles/view/".$user_role['id']."?check=permissions",
                                   'data-toggle'=>"modal",
                                   'data-target'=>"#ajax-modal"
                                  )); ?>
       </div>
    </div>
  <?php endforeach; ?>



  <?php load_buttons('submit', array('controller' => $controller,
                                     'name' => 'SAVE',
                                     'class' => 'btn_blue')) ?>
<!-- </form> -->
<?= form_close();?>
