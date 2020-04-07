<?php
	function available_urls_before_login(){ 
		return array('users/login/index','users/login/create','users/login/store', 
									'users/login/update',
									'users/ad_login/index','users/ad_login/create','users/ad_login/store',
									'users/ad_login/update', 
									'users/forgot_password/create','users/forgot_password/store', 
									'users/register/create', 'users/register/store' ,
									'user_device_token/user_device_token/store',
									'core_users/email_verification/update/', 
									'socials_media/google/index','socials_media/google/store',
									'socials_media/facebook/index','socials_media/facebook/store',
									'slack/slack_login/index','slack/slack_login/store',
									'sys/migrations/index','sys/migrations/create','sys/migrations/store','socials_media/twitter/index','socials_media/twitter/index','socials_media/linkedin/index','socials_media/linkedin/index');
	}

	function available_urls_after_login() {
		return array('users/logout/index','users/user_email_verify/create',
									'users/user_email_verify/store','users/user_email_verify/update',
									'users/user_mobile_verify/create','users/user_mobile_verify/store',
									'users/user_mobile_verify/update',
									'users/reset_password/edit','users/reset_password/update',
									'sys/search/index',
									'users/change_password/create','users/change_password/store',
									'communications/templates/create','communications/templates/store',
									'communications/templates/edit','communications/templates/update',
									'communications/templates/index','communications/templates/view',
									'user_device_token/user_device_token/store',
									'slack/slack_login/index','slack/slack_login/store',
                  'users/reset_password/update',
									'sys/search/index','sys/search/getAutoCompleteDropDownData',
                  'communications/inapp_notifications/index',
                  'communications/inapp_notifications/create',
                  'communications/inapp_notifications/store',
                  'communications/inapp_notifications/edit',
                  'communications/inapp_notifications/update',
                  'communications/inapp_notifications/view', 'sys/webserver_analytics/index');
}

function excluded_urls_before_after_login(){
    return array('slack/slack_login/index','sys/migrations/index','sys/migrations/create','slack/slack_login/store','sys/migrations/index','sys/migrations/view');
	}
?>
