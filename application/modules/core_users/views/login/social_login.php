<div class="text-center">
<?php if(defined('GOOGLE_CLIENT_ID') || defined('FACEBOOK_APP_ID') || defined('TWITTER_CONSUMER_TOKEN') || defined('LINKEDIN_CLIENT_ID')){ ?>
  <h5 class="text-center m-0">or</h5>
<?php } ?>
  <?php 
    if(defined('GOOGLE_CLIENT_ID')) {
      load_buttons('anchor', array('name' => 'Sign in with Google',
                                    'icon'=>'fab fa-google pr-2',
                                    'class' =>'btn-lg btn_blue my-3',
                                    'layout'=> 'application',
                                    'href'=>BASE_URL.'socials_media/google/'));
    }
    if(defined('FACEBOOK_APP_ID')){
      load_buttons('anchor', array('name' => 'Sign in with Facebook',
                                    'icon'=>'fab fa-facebook-f pr-2',
                                    'class' =>'btn-lg btn_blue my-3',
                                    'layout'=> 'application',
                                    'href'=>BASE_URL.'socials_media/facebook/')); 
    }
    if(defined('TWITTER_CONSUMER_TOKEN')){
      load_buttons('anchor', array('name' => 'Sign in with Twitter',
                                    'icon'=>'fab fa-twitter pr-2',
                                    'class' =>'btn-lg btn_blue my-3',
                                    'layout'=> 'application',
                                    'href'=>BASE_URL.'socials_media/twitter/')); 
    }
    if(defined('LINKEDIN_CLIENT_ID')){
      load_buttons('anchor', array('name' => 'Sign in with LinkedIn',
                                    'icon'=>'fab fa-linkedin-in pr-2',
                                    'class' =>'btn-lg btn_blue my-3',
                                    'layout'=> 'application',
                                    'href'=>BASE_URL.'socials_media/linkedin/')); 
    }
    if(defined('SLACK_CLIENT_ID')){
      load_buttons('anchor', array('name' => 'Sign in with Slack',
                                    'icon'=>'fab fa-slack pr-2',
                                    'class' =>'btn-lg btn_blue my-3',
                                    'layout'=> 'application',
                                    'href'=>BASE_URL.'slack/slack_login/')); 
    }

  ?>
</div>
