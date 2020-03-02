<?php
class Apache_logs extends BaseController {
	protected $load_helper = false;
	public function __construct() {
  	parent::__construct();
	}

  public function view($id='') {
    $file = '/var/log/apache2/error.log';
    $log = file_get_contents($file, FILE_USE_INCLUDE_PATH, null); 
    $lines = explode("\n", $log); 
    $array_reverse = array_reverse($lines);
    $content = array_slice($array_reverse,1);
    $data = array('logs'=>$content,
                  'layout'=>'application',
                  'count'=>count($array_reverse),
                  'limit'=>40,
                  'log_from'=>'apache',
                  'heading'=>'Apache Log'); 
    $this->load->render('php_logs/php_logs', $data);
  }

}

?>