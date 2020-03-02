<?php

class Core_users_user_role_model extends BaseModel
{
  protected $table_name = 'users_user_roles';
  public function __construct($data=array()) {
    parent::__construct($data);
  }

  public function validation_rules($klass='', $index=0) {
    return array(
      array(
       'field' => 'users_user_roles[user_role_id]',
       'label' => 'User Role',
       'rules' => 'trim|required'));
  }

}
