<?php

class Migration_model extends BaseModel {
	protected $table_name = 'migrations';
  protected $id = 'id';
  private $_migration_regex = '/^\d{14}_(\w+)$/';

  public function __construct($data=array()) {
    parent::__construct($data);
  }

  public function store($after_save=TRUE) {
    if (empty($this->attributes['version'])) {
      $this->create_migration_file();
      return $this->attributes;
    } else
      parent::store($after_save);
   }

  private function create_migration_file() {
    $file_name = $this->_format_file_name($this->attributes['file_name']);
    $this->attributes['migration_version'] = $this->_get_migration_version();
    $file_full_name = $this->attributes['migration_version'].'_'.$file_name.'.php';
    $file_path = 'application/modules/'.$this->attributes['module_name'].'/migrations';
    makedirs($file_path,755);
    $file = 'application/modules/'.$this->attributes['module_name'].'/migrations/'.$file_full_name;
    $file_content = $this->_get_file_content($file_name);
    if (!write_file($file, $file_content)) {
      $error = 'Could not create file!'  . PHP_EOL;
      show_error($error);
    }
    echo 'Migration File "'.$file_full_name.'" successfully created!'.PHP_EOL;
    return;
  }



  public function run() {
      $module = (isset($_GET['module_name'])?$_GET['module_name']:'');
      if(empty($module)){ 
        $scandir = scandir(APPPATH.'modules');
        $sys_module = array('sys');
        $scandir = array_reverse(array_merge($scandir,$sys_module));
      }

      else $scandir = array($module);

      foreach ($scandir as $module) {
        if ($module=='.' OR $module=='..') continue;
        $migration_path = APPPATH.'modules/'.$module.'/migrations/';
        $migrations_files = $this->find_migrations($migration_path);
        if(!empty($migrations_files)){
          foreach ($migrations_files as $timestamp => $file_path) {
            $file_name = basename($file_path);
            $is_migration_exists = $this->migration_model->find('',array('version'=>$timestamp,'module_name'=>$module));
            if(empty($is_migration_exists)){
              include_once($file_path);
              $class = 'Migration_'.ucfirst(strtolower($this->_get_migration_name(basename($file_name, '.php'))));

              $migration_obj = new $class;
              $migration_obj->up();

              
              $migration_data['version']      = $timestamp;
              $migration_data['module_name']  = $module;
              $migration_data['file_name']    = str_replace('_', ' ', strtolower($this->_get_migration_name(basename($file_name, '.php'))));
              $migration_model_obj = new Migration_model($migration_data);
              $migration_model_obj->save();
              echo 'Migration Version '.$timestamp.' executed';
            }
          }
        } 
      }
  }

  public function before_validate() {
    $this->attributes['file_name'] = strtolower($this->attributes['file_name']);
  }

  public function validation_rules($klass='') {
    return array(array('field' => 'migrations[file_name]',
                       'label' => 'File Name',
                       'rules' => array('trim','required','max_length[255]',
                                    array('unique_name',
                                      array($this, 'name_unique'))),
                       'errors'=>array('unique_name' => "File Name must be unique.")),
                 array('field' => 'migrations[module_name]',
                       'label' => 'Module Name',
                       'rules' => array('trim', 'required')));
  }
  
  public function name_unique($file_name){
    return parent::check_unique('file_name');
  }

  private function _format_file_name($file_name = '') {
    return str_replace(' ', '_', $file_name);
  }

  private function _get_migration_number($migration) {
    return sscanf($migration, '%[0-9]+', $number)
      ? $number : '0';
  }

  private function _get_migration_name($migration) {
    $parts = explode('_', $migration);
    array_shift($parts);
    return implode('_', $parts);
  }

  private function _get_migration_version() {
    $migration_version = date("YmdHis");
    if ($this->config->item('migration_type') === 'sequential') {
      $migration_version = (int) ( (int) $this->_get_version() + 1);
      $migration_version = str_pad($migration_version, 3, "0", STR_PAD_LEFT);
    }
    return $migration_version;
  }

  private function find_migrations($migration_path) {
    $migrations = array();
    $this->is_table_exists();
    // Load all *_*.php files in the migrations path
    foreach (glob($migration_path.'*_*.php') as $file) {
      $name = basename($file, '.php');
      // Filter out non-migration files
      if (preg_match($this->_migration_regex, $name)) {
        $number = $this->_get_migration_number($name);

        // There cannot be duplicate migration numbers
        if (isset($migrations[$number])) {
          $this->_error_string = sprintf($this->lang->line('migration_multiple_version'), $number);
          show_error($this->_error_string);
        }
        $migrations[$number] = $file;
      }
    }
    ksort($migrations);
    return $migrations;
  }

  private function _get_file_content($file_name = '') {
    // Php opening tag
    $file_content = '<?php'  .  PHP_EOL  .  PHP_EOL;  // <?php
    $file_content .= 'defined(\'BASEPATH\') OR exit(\'No direct script access allowed\');'  .  PHP_EOL;
    // Class
    $file_content .= PHP_EOL  .  'class Migration_'  .  $file_name; // class File_name
    $file_content .= ' extends CI_Model {'  .  PHP_EOL  .  PHP_EOL; // extends 
    // Public function up content
    $file_content .= '  public function up()'  .  PHP_EOL;
    $file_content .= '  {'  .  PHP_EOL;
    $file_content .= '    $this->db->query("");' . PHP_EOL;
    $file_content .= '  }'  .  PHP_EOL;
    $file_content .= PHP_EOL;
    // The file name consists modify
    // Class closing tag
    $file_content .= PHP_EOL  .  '}'  .  PHP_EOL  .  PHP_EOL; // }
    // Php closing tag
    $file_content .= '?>';
    return $file_content;
  }

  private function is_table_exists(){
    if ( ! $this->db->table_exists('migrations'))
    {
      include_once(FCPATH.'application/modules/sys/migrations/20191111162906_migrations.php');
      $class = 'Migration_migrations';
      $migration_obj = new $class;
      $migration_obj->up();
    }
  }
 

}
?>