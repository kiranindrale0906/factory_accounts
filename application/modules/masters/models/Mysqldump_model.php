<?php
require_once(APPPATH.'modules/sys/models/Core_mysqldump_model.php');
class Mysqldump_model extends Core_mysqldump_model {
	public $db_name = 'default';
  public function __construct($data=array()) {
    parent::__construct($data);
    $this->db_conn = $this->db;
  }

}