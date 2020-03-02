<?php

class Core_user_role_permission_model extends BaseModel
{
  protected $table_name = 'user_role_permissions';
  protected $id = 'id';

  public function __construct($data=array()) {
    parent::__construct($data);
  }
}
