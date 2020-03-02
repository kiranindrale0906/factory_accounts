<?php echo form_open_multipart(get_form_action($controller, $action, $record) , array('id'=> 'register', 'method'=> 'post', 'class'=> 'form-horizontal fields-group-md')); ?>
  <div class="row">
    <?php if ($action == 'edit' || $action == 'update'): ?>
      <?php load_field('hidden', array('field' => 'id')) ?>
    <?php endif; ?>
    <?php load_field('plain/text', array('field' => 'name',
                                        'layout'=>'application',
                                        'class'=>'custom_form_control',
                                        'col'=>'col-12'
    )) ?>
    <?php load_field('plain/text', array('field' => 'email_id',
                                   'layout'=>'application',
                                    'class'=>'custom_form_control',
                                    'col'=>'col-12'
    )) ?>
    <?php load_field('plain/text', array('field' => 'mobile_no',
                                   'layout'=>'application',
                                   'class'=>'custom_form_control',
                                   'col'=>'col-12'
    )) ?>
    <?php load_field('plain/password', array('field' => 'encrypted_password',
                                      'layout'=>'application',
                                      'class'=>'custom_form_control',
                                      'col'=>'col-12'
    )) ?>
    <?php load_field('plain/password', array('field' => 'confirm_password',
                                       'name' => 'confirm_password',
                                       'layout'=>'application',
                                       'class'=>'custom_form_control',
                                       'col'=>'col-12'
     )) ?>
     <div class="col-12 p-0 mt-2">
      <?php load_buttons('anchor', array(
                      'name'=>'Login',
                      'class'=>'btn-md link medium p-0 float-right blue',
                      'layout'=>'application',
                      'href'=>BASE_URL.'users/login/create'
    )); ?>
    </div>   
  </div>
  <?php load_buttons('submit', array('name' => 'Submit',
                                     'class' =>'btn-lg btn_black d-block mx-auto my-3',
                                     'layout'=> 'application')); ?>
  
</form>

