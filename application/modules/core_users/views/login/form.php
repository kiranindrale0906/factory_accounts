
<?php echo form_open_multipart(BASE_URL.'users/'.$this->router->class.'/store');?>

  <div class="row">
    <?php load_field('plain/text', array('field' => 'email_id', 
                                  'layout'=>'application',
                                  'class'=>'custom_form_control',
                                  'col'=>'col-12'
    ))?>
    <?php load_field('plain/password',array('field' => 'password',
                                      'name' => 'password',
                                      'layout'=>'application',
                                      'class'=>'custom_form_control',
                                      'col'=>'col-12'
    )) ?>
    <div class="col-12 p-0 mt-2">
      <?php load_buttons('anchor', array(
                      'name'=>'Forgot Password ?',
                      'class'=>'btn-sm link medium p-0 float-right',
                      'layout'=>'application',
                      'href'=>BASE_URL.'users/forgot_password/create'
    )); ?>
    </div>
    <?php 
      if($this->router->class =='ad_login'){
        $url = BASE_URL.'users/login/create';
        $title = 'User Login';
      }else{
        $url = BASE_URL.'users/ad_login/create';
        $title = 'AD Login';
      }
    if(AD_LOGIN){ ?>
      <div class="col-12 p-0 mt-2">
        <?php load_buttons('link', array(
                          'name'=>$title,
                          'class'=>'btn btn-sm link blue medium float-right',
                          'href'=>$url
        )); ?> 
      </div>
    <?php }?>
 
  </div>    
 
  <?php load_buttons('submit', array('name' => 'Login',
                                     'class' =>'btn-lg btn_black d-block mx-auto my-3',
                                     'layout'=> 'application')); ?>

  <?php $this->load->view('social_login'); ?>

  <p class="medium text-center">Don't have an account ? <a class="blue underline" 
      href= "<?=BASE_URL?>users/register/create">Register</a></p>
<?= form_close();?>

