<?php
class  Core_register_model extends BaseModel {
  protected $table_name = 'users'; 
  protected $id = 'id';
  public $router_class = 'register';
  public function __construct($data=array()) {
    parent::__construct($data);
    $this->load->model(array('users/user_activity_model', 'communications/inapp_notification_model', 'triggers/communication_model'));
  }
  public function validation_rules($klass='') {
    $rules = array(
              array('field' => 'register[name]',
                    'label' => 'Name',
                    'rules' => array('trim', 'required', 'max_length[50]')),
              array('field' => 'register[email_id]',
                    'label' => 'Email', 
                    'rules' => array('trim', 'required', 'max_length[255]', 'valid_email', 'is_unique[users.email_id]')),
              array('field' => 'register[mobile_no]',
                    'label' => 'Contact No',
                    'rules' => array('trim', 'required', 'regex_match[/^[0-9]{10}$/]')),
              array('field' => 'register[encrypted_password]',
                    'label' => 'Password',
                    'rules' => 'trim|required|max_length[50]|matches[confirm_password]'),
              array('field' => 'confirm_password',
                    'label' => 'Confirm Password',
                    'rules' => 'trim|required|max_length[50]')
            );
    return $rules;
  }

  public function before_save($action){
    $string = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $this->attributes['access_token'] = md5(substr(str_shuffle($string), 0, 15));
    $this->attributes['encrypted_password'] = md5($this->attributes['encrypted_password']);
    $this->attributes['mobile_verify_otp'] = mt_rand(100000, 999999);
  }

  public function after_save($action){
    $this->user_activity_model->send('user', 'register', 'user_id', $this->attributes['id']);
  }

  public function send_in_app_notification($model, $column_name, $value){
    $user_id = $this->user_activity_model->find('value', array('id' => $value))['value'];
    $_POST = array('user_id' => $user_id,
                   'link'    => '',
                   'message' => 'Welcome to our application.');
    $inapp_notification = new inapp_notification_model($_POST);
    $inapp_notification->save(0);
    return array('status' => true);
  }

  public function check_user_mobile_exists($model, $column_name, $value){
    $user_id = $this->user_activity_model->find('value', array('id' => $value))['value'];
    $mobile_no = $this->$model->find('mobile_no', array('id' => $user_id))['mobile_no'];
    $result = 'false';
    if($mobile_no != ''){
      $result = 'true';
    }
    return array('status' => true,  'result' => $result);
  }

  public function send_sms_notification($model, $column_name, $value){
    $user_id = $this->user_activity_model->find('value', array('id' => $value))['value'];
    $data = $this->$model->find('name, CONCAT("91", mobile_no) as mobile_no', array('id' => $user_id));
    $this->communication_model->send_communication_sms($data, 'user_registration');
    return array('status' => true);
  }

  public function send_email_notification($model, $column_name, $value){
    $user_id = $this->user_activity_model->find('value', array('id' => $value))['value'];
    $data = $this->$model->find('name, email_id', array('id' => $user_id));
    $this->communication_model->send_communication_email($data, 'user_registration');
    return array('status' => true);
  }
}
