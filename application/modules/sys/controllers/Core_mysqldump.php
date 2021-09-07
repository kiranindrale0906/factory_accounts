<?php
class Core_mysqldump extends BaseController {
	public $db_conn = 'default';
	public function __construct() {
  	parent::__construct();
      ini_set('memory_limit', '-1');
      ini_set('max_execution_time', '3000');
	}


	public function index(){
		$scandir['scan_dir'] = scandir(DB_BACKUP_FILE_PATH);
		rsort($scandir['scan_dir']);
		$scandir['layout'] = 'application';
		$this->load->render('db_dump/index',$scandir);
		
	}

	public function create() {

		if(HOST == 'BACKUP ACCOUNTS'){
			$this->import_database($_GET['file_name']);
			$this->session->unset_userdata('user_id');
			$this->session->sess_destroy();
			redirect('settings/mysqldump');
		}
		echo "You are on wrong host to perfrom this operation."; die;
	}

	private function import_database($file_name){
    $temp_line = '';
    $this->delete_enteries_from_privious_database();
    $file =  DB_BACKUP_FILE_PATH.$file_name;
    if (file_exists($file))
    {
      $lines = gzfile($file);
      $statement = '';
      foreach ($lines as $line)
      {
        $statement .= $line;
        if (substr(trim($line), -1) === ';')
        {
          if(HOST == 'BACKUP ACCOUNTS'){
            $this->db->simple_query($statement);
            $statement = '';
          }
        }
      }
    }
	}

	private function delete_enteries_from_privious_database(){
		$sql = "CREATE DATABASE IF NOT EXISTS ".$this->db->database;
		$result = $this->db->query($sql); 
		$sql_select = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='".$this->db->database."'";
		$result = $this->db->query($sql_select)->result_array();
		$this->load->dbforge();
		foreach($result as $table_name){
			$this->dbforge->drop_table($table_name['TABLE_NAME']);		
		}

	}

	
}