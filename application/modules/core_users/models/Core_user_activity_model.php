<?php
class Core_user_activity_model extends BaseModel {
  protected $table_name = 'user_activities';
  protected $id = 'id';

  public function __construct($data=array()) {
    parent::__construct($data);
    $this->load->model(array('workflows/workflow_case_model'));
  }

  public function before_save($action){
    $this->formdata['user_activities']['user_id']    = ! empty($_SESSION['user_id']) ?  $_SESSION['user_id'] : null;
    $this->formdata['user_activities']['session_id'] = session_id();
    return $this->formdata;
  }

  public function after_save($action){
    $this->workflow_case_model->create_workflow_case($this->attributes['id'], $this->attributes['category'].'_'.$this->attributes['action']);
  }

  public function send($category, $action, $label = null, $value = null){
    $data = array('category'   => $category,
                  'action'     => $action,
                  'label'      => $label,
                  'value'      => $value,
                  'user_id'    => ! empty($_SESSION['user_id']) ?  $_SESSION['user_id'] : null,
                  'session_id' => session_id());
    $user_activitiy = new Core_user_activity_model($data);
    $user_activitiy->save();
  }

  public function validation_rules($klass='') {
    return array(
      array(
        'field' => 'user_activities[category]',
        'label' => 'Category',
        'rules' => array('trim', 'required')
      ),
      array('field' => 'user_activities[action]',
        'label' => 'Action',
        'rules' => array('trim', 'required')
      ),
      array('field' => 'user_activities[label]',
        'label' => 'Label',
        'rules' => array('trim')
      ),
      array('field' => 'user_activities[value]',
        'label' => 'Value',
        'rules' => array('trim')
      ),
    );
  }
}