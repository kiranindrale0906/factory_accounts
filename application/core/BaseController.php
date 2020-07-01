<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/*************************************************************************
*
* ASCRA TECHNOLOGIES CONFIDENTIAL
* __________________
*
*  All Rights Reserved.
*
* NOTICE:  All information contained herein is, and remains
* the property of Ascra Technologies and its suppliers,
* if any.  The intellectual and technical concepts contained
* herein are proprietary to Ascra Technologies
* and its suppliers and may be covered by U.S. and Foreign Patents,
* patents in process, and are protected by trade secret or copyright law.
* Dissemination of this information or reproduction of this material
* is strictly forbidden unless prior written permission is obtained
* from Ascra Technologies.
*/
/*version : 1.3*/ 

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . "third_party/MX/Controller.php";
require APPPATH . "core/control_traits/Respond_to_trait.php";
require APPPATH . "core/control_traits/Export_trait.php";
require APPPATH . "core/control_traits/Record_list_trait.php";
require APPPATH . "core/control_traits/Bar_code_trait.php";
require_once APPPATH . "core/logic_traits/Security_trait.php";

if($_SERVER['REQUEST_METHOD'] == "OPTIONS") {
  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS, PUT");
  header("Access-Control-Allow-Headers: Authorization, authToken, hash");
  die();
}


use mikehaertl\wkhtmlto\Pdf;
class BaseController extends MX_Controller {
  use respond_to_trait;
  use export_trait;
  use record_list_trait;
  use bar_code_trait;
  use security_trait;

  protected $model = '';
  protected $class = '';
  protected $xss_clean = '';
  protected $where = array();

  public function __construct() {
    parent::__construct();
    $this->load_model();
    $this->controller =  $this->router->fetch_class();
    $this->module =  $this->router->fetch_module();
    $this->model->router_class = $this->router->class;
    $this->date_fields = array();
    $this->xss_clean_form_data = true;
    $this->non_sanitize_fields = array();
    $this->data['message'] = '';
    $this->data['layout'] = 'application';
    $this->data['open_modal'] = TRUE;
    $this->data['validation_klass'] = '';
    $this->data['import'] = FALSE; 
  }

  public function index() {
    if(isset($_GET['bar_code']) && $_GET['bar_code'] == 1) $this->get_bar_codes();
    if (isset($_GET['autocomplete']) && $_GET['autocomplete']==1) $this->set_autocomplete_data();
    if(isset($_GET['table_filter']) && $_GET['table_filter'] == 1)
      $this->_select_arrange_column($this->where);
    if(isset($_GET['export']) && !isset($_GET['page_no'])):$this->_export_popup_html();
    elseif(isset($_GET['export']) && isset($_GET['page_no'])):$this->_export();
    elseif(isset($_GET['pdf']) && isset($_GET['pdf'])):
      $this->_get_pdf(@$this->data["pdf_html"]);
    else:
      $records = $this->_getAllRecords($this->where);
      $records['count'] = $this->getRecordCounts('',TRUE);
      if (empty($this->data)) $this->data=array();
      $this->data = array_merge($records, $this->data);
      if(method_exists($this, '_set_page_header')) $this->_set_page_header();
      $this->_respond_to_index($this->data);
    endif;  
  }

  public function create() {
    if (!$this->data['import']) $this->data['import'] = @$_GET['import'];
    if (!isset($this->data['record'])) $this->data['record'] = array();
    $this->load_form();
  }

  public function edit($id) {
    if (!isset($this->data['record'])) $this->data['record'] = $this->model->find('', array('where' => array('id' => $id)));
    if (empty($this->data['record']) || $this->data['record'] === FALSE)
      $this->_respond_to_record_not_found($this->data);
    else
      $this->load_form();
  }

  public function store() {
    $this->save();
  }

  public function update($id) {
    $this->save();
  }

  public function delete($id) {
    $record = $this->model->find('', array('where' => array('id' => $id)));
    if (empty($record) || $record === FALSE) {
      $this->_respond_to_record_not_found($this->data);
    } else {
      $data = $this->model->delete($id);
      $this->_respond_to_success_on_delete($record); 
    }
  }
  
  public function view($id) {
    if ($this->redirect_after_save =='index') {
      if(!empty($this->session->flashdata('success')))
        $this->session->set_flashdata('success',$this->session->flashdata('success'));
      if (isset($_GET['http_referer']) && !empty($_GET['http_referer']))
        redirect($_GET['http_referer']);
      else
        redirect(base_url($this->router->module.'/'.$this->router->class . '?added=true'));
    } else {
      if (!isset($this->data['record'])) $this->data['record'] = $this->model->find('', array('where' => array('id' => $id)));
      if(isset($_GET['download']) AND $_GET['download'] == 1) $this->upload_file->download($this->data['record'],$id); 
      if (empty($this->data['record']) || $this->data['record'] === FALSE):
        $this->_respond_to_record_not_found($this->data);
      else:
        if (isset($_GET['http_referer'])) $this->data['http_referer'] = $_GET['http_referer'];
        if(method_exists($this, '_get_view_data')) $this->_get_view_data();
        if(method_exists($this, '_set_page_header')) $this->_set_page_header();
        $this->_respond_to_success_on_view($this->data); 
      endif;
    }
  }

  private function load_form() {
    if (isset($_SERVER['HTTP_REFERER'])) $this->data['http_referer'] = $_SERVER['HTTP_REFERER'];
    if(method_exists($this, '_get_form_data')) $this->_get_form_data();
    if(method_exists($this, '_set_page_header')) $this->_set_page_header();
    $this->_respond_to_load_form($this->data);
  }
  
  private function save() {
    //$_POST = ($this->xss_clean_form_data) ? sanitize_input_text($_POST) : $_POST;
    $this->check_securities();
    if(isset($_POST['import'])) $this->data['import']=1;
    //pr($_POST);
    $this->set_date_format();
    $model_obj = new $this->model($_POST);
    if (method_exists($this, '_before_validate')) 
      $model_obj->set_formdata_and_attributes($this->_before_validate($model_obj->formdata, $this->router->method));
    
    if ($model_obj->validate($this->data['validation_klass'])) {
      if(isset($this->data['file_data'])) {
        $model_obj->formdata = $this->upload_file->upload_files($model_obj->formdata, $this->data['file_data']);
      }
      if (method_exists($this, '_before_save')) 
        $model_obj->set_formdata_and_attributes($this->_before_save($model_obj->formdata, $this->router->method));
      $model_obj->save();
      if (method_exists($this, '_after_save')) 
        $model_obj->set_formdata_and_attributes($this->_after_save($model_obj->formdata, $this->router->method));

      $this->_respond_to_success_on_save($model_obj);
    } else {
      $this->data['record'] = $model_obj->attributes;
      if(method_exists($this, '_get_form_data')) $this->_get_form_data();
      if(method_exists($this, '_set_page_header')) $this->_set_page_header();
      $this->_respond_to_error_on_save($model_obj);
    }
  }

  private function set_date_format() {
    foreach ($this->date_fields as $date_field) {
      $table = $date_field[0];
      $field = $date_field[1];
      if (isset($_POST[$table][$field]) && (!empty($_POST[$table][$field]))) {
        $date = str_replace('/', '-', $_POST[$table][$field]);
        $_POST[$table][$field] = date('Y-m-d', strtotime($date));
      }
    }
  }
  
  private function load_model($model = '') {
    $this->class = $this->router->class;
    if ($model != '') {
        $model = $model . '_model';
    } else {
      if (isset($this->_model)) {
        $model = $this->_model;
      } else if ($model == '') {
        $model = singular($this->class) . '_model';
      }
    }
    $this->load->model($model);
    $this->model = $this->$model;
  }

  private function is_ajax() {
    $is_ajax = (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
    return $is_ajax;
  }

  private function is_api_request() {
    $array = $this->input->request_headers();
    $header = array_change_key_case($array, CASE_LOWER);

    if(array_key_exists ('authorization', $header ) || array_key_exists ('authtoken', $header )){
      return TRUE;
    }
    return FALSE; 
  }

}