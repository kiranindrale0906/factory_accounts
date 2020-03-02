<?php
class Email_verification_model extends BaseModel {
  protected $table_name = 'users';
  protected $id = 'id';
  
  function __construct() {
    parent::__construct();
  }
}