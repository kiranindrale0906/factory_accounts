<?php
class Migrations extends BaseController {
  
  public function __construct() {
    parent::__construct();
  }

  public function index($id='') {
    if(isset($_GET['module_name']) || $id == 'run') $this->model->run();
    parent::index();
  }


  public function _get_form_data() {
    $modules = scandir(APPPATH.'modules');
    foreach ($modules as $module) {
      if ($module=='.' || $module=='..') continue;
      $this->data['modules'][] = array('id' => $module, 'name' => 'module');  
    }
  }

  // private function check_migration_status() {
  //   $migration_enabled = $this->config->item('migration_enabled');
  //   if($migration_enabled  != TRUE) {
  //     echo 'Please enable migration to use this service.'; 
  //     exit;
  //   }
  // }
}
?>