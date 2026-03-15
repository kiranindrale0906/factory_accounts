<?php
class Core_user_mobile_verify_model extends BaseModel {
  protected $table_name = 'users';
  protected $id = 'id';
  public $router_class="user_mobile_verify";
  protected $load_trigger = true;
  public function __construct($data=array()) {
    parent::__construct($data);
  }

  public function validation_rules($klass='') {
    if($this->router->method=="create" || $this->router->method=="store") {
      return  array(array('field' => 'user_mobile_verify[verify_code]', 'label' => 'Verify code',
                          'rules' => array('trim', 'required',
                                     array('valid_mobile_verify_code', array($this, 'is_valid_mobile_verify_code'))),
                          'errors'=> array('valid_mobile_verify_code' => "Invalid verification code.")));  
    }
    else
    {
      return  array(array('field' => 'user_mobile_verify[verify_code]', 'label' => '',
                          'rules' => array('trim', 'required')));
    }
    
  }

  public function is_valid_mobile_verify_code($verify_code) {
    $user_id=$_SESSION['user_id'];
    $result = $this->get('id',  array('id'=>$user_id, 'mobile_verify_code'=>$verify_code));
    return (empty($result)) ? false : true;
  }
  
  public function after_save($action)
  {
    if($action=="update") {
      $datetime_diff_minute=get_no_of_period_from_datetime($this->attributes['sms_sent_at'],'','i');
      if($datetime_diff_minute>0 || empty($this->attributes['sms_sent_at'])){
        $this->attributes['sms_sent_at']=date('Y-m-d H:i:s');
        $this->update(false,array('id'=>$this->attributes['id']));
      }
    }
  }
}