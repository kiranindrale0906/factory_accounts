<!-- <h5 class="heading blue text-center text-uppercase">Forgot Password</h5>   -->
<p class="medium text-center">Enter your Email and instructions will be sent to you!</p>
<p><?php echo $this->session->flashdata('loginerror');?></p>       
<form method="post" 
      class="form-horizontal fields-group-md form_radius_none" 
      enctype="multipart/form-data"
      action="<?= BASE_URL.'users/forgot_password/store'; ?>">
  <div class="row">
    <?php load_field('plain/text', array('field' => 'email_id',
                                         'layout'=>'application',
                                         'class'=>'custom_form_control',
                                         'col'=>'col-12'
    ))?>  
    <div class="col-12 p-0 mt-2">
      <?php load_buttons('anchor', array(
                      'name'=>'Login',
                      'class'=>'btn-md link medium p-0 blue float-right',
                      'layout'=>'application',
                      'href'=>BASE_URL.'users/login/create'
    )); ?>
  </div>
  <?php load_buttons('submit', array('name' => 'Submit',
                                     'class' =>'btn-lg btn_black d-block mx-auto my-3',
                                     'layout'=> 'application')); ?>
</form>