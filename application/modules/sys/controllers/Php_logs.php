<?php
class Php_logs extends BaseController {
	protected $load_helper = false;
	public function __construct() {
  	parent::__construct();
	}

  public function view($id='') {
  		$limit = 20;   
  		if(isset($_GET['page_no']))
  			$start = ($_GET['page_no'] * $limit);
  		else
  			$start = 0;
      $date = isset($_GET['date'])?$_GET['date']:'';
      $data['title'] = 'Error Log';
      $data['clear'] = site_url('tool/error_log/clear');
      $data['log'] = '';
      if(empty($date)) $date = date('Y-m-d');
      else {
      	$date_format = date_create($date);
				$date = date_format($date_format,'Y-m-d');
      }
      $file = FCPATH . 'application/logs/' . 'log-'.$date.'.txt';
      if(file_exists($file)){
        $log = file_get_contents($file, FILE_USE_INCLUDE_PATH, null); 
        $lines = explode("\n", $log); 
        $array_reverse = array_reverse($lines);
        $content = array_slice($array_reverse, $start,$limit); 
        $data = array('logs'=>$content,
                  'layout'=>'application',
                  'count'=>count($array_reverse),
                  'heading'=>'PHP Logs','limit'=>$limit); 
        $this->load->render('php_logs/php_logs', $data);
      }else{
      	echo '<p>Logs Not found of given date.</p>'.' '.$_GET['date'];
      }
  }

}

?>