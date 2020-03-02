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
