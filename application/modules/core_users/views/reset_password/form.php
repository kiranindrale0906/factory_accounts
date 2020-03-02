<!-- <h5 class="heading blue text-center text-uppercase">Reset Password</h5>   -->
<p><?php echo $this->session->flashdata('loginerror');?></p>       
<form method="post" 
      class="form-horizontal fields-group-md form_radius_none" 
      enctype="multipart/form-data"
      action="<?= BASE_URL.'users/reset_password/update/1'; ?>">
  <div class="row">
    <?php load_field('plain/password',array('field' => 'password',
                                      'layout'=>'application',
                                       'class'=>'custom_form_control',
                                       'col'=>'col-12'
    )) ?>
    <?php load_field('plain/password',array('field' => 'confirm_password',
                                            'name' => 'confirm_password',
                                            'layout'=>'application',
                                            'class'=>'custom_form_control',
                                            'col'=>'col-12'
    )) ?>   
    <?php load_field('hidden',array('field' => 'reset_token')) ?> 
  </div>
  <?php load_buttons('submit', array('name' => 'Submit',
                                     'class' =>'btn-lg btn_black d-block mx-auto my-3',
                                     'layout'=> 'application')); ?>
</form>
