<?php
class Core_user_email_verify_model extends BaseModel {
  protected $table_name = 'users';
  protected $id = 'id';
  public $router_class="user_email_verify";
  protected $load_trigger = true;
  public function __construct($data=array()) {
    parent::__construct($data);
  }

  public function validation_rules($klass='') {
    if($this->router->method=="create" || $this->router->method=="store") {
      return  array(
              array('field' => 'user_email_verify[verify_code]', 'label' => 'Verify code',
                    'rules' => array('trim', 'required',
                               array('valid_email_verify_code', array($this, 'is_valid_email_verify_code'))),
                    'errors'=> array('valid_email_verify_code' => "Invalid verification code.")));
    }
    else
    {
      return  array(array('field' => 'user_email_verify[verify_code]', 'label' => '',
                          'rules' => array('trim')));
    }
  }

  public function after_save($action)
  {
    if($action=="update") {
      $datetime_diff_minute=get_no_of_period_from_datetime($this->attributes['email_sent_at'],'','i');
      if($datetime_diff_minute>0 || empty($this->attributes['email_sent_at'])){
        $this->attributes['email_sent_at']=date('Y-m-d H:i:s');
        $this->update(false,array('id'=>$this->attributes['id']));
      }
    }
  }

  public function is_valid_email_verify_code($verify_code) {
    $user_id=$_SESSION['user_id'];
    $result = $this->get('id',  array('email_verify_code'=>$verify_code,  'id'=>$user_id));
    if(empty($result)){
      return false;
    } 
    else
      return true;
  }
}