<?php

class Core_mysqldump_model extends BaseModel {
	public $db_name = 'default';
  public function __construct($data=array()) {
    parent::__construct($data);
    $this->db_conn = $this->db;
  }

	public function import_database($file_name){
    $temp_line = '';
    $file =  APPPATH.'database_backups/'.$file_name;
    if (file_exists($file))
    {
      $lines = file($file);
      $statement = '';
      foreach ($lines as $line)
      {
        $statement .= $line;
        if (substr(trim($line), -1) === ';')
        {
          if(HOST == 'backup-argold.ascratech.com'){
            $this->db->simple_query($statement);
            $statement = '';
          }
        }
      }
    }
	}
}