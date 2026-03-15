<h5 class="heading blue text-center text-uppercase">Change Password</h5>  
<form method="post" 
      class="form-horizontal fields-group-md form_radius_none" 
      enctype="multipart/form-data"
      action="<?= ADMIN_PATH.'users/change_password/store' ?>">
  <div class="row">
    <?php load_field('password',array('field' => 'old_password', 'grid' => 'col-12')) ?>
    <?php load_field('password',array('field' => 'new_password', 'grid' => 'col-12')) ?>
    <?php load_field('password',array('field' => 'confirm_password', 'name' => 'confirm_password', 'grid' => 'col-12')) ?>   
  </div>
  <hr/>
  <?php load_buttons('button', array(
                    'name'=>'Submit',
                    'class'=>'btn btn-md btn_blue d-block mx-auto'
                  )); ?>
</form>
