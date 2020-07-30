<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Production_summary extends BaseController {
  public function __construct() {
    parent::__construct();
    $this->load->model(array('masters/account_model'));
  }

  public function index() {
    $this->_get_form_data();
    $this->get_production_summary();
    $this->load->render($this->router->class."/index", $this->data);
  }

  public function _get_form_data() {
    if(!isset($this->data['record'])) $this->data['record'] = array();
    if (!empty($_GET['production_summary']['product_name'])) $this->data['record']['product_name'] = $_GET['production_summary']['product_name'];
    if (!empty($_GET['production_summary']['in_purity']))    $this->data['record']['in_purity']    = $_GET['production_summary']['in_purity'];
    if (!empty($_GET['production_summary']['category_one'])) $this->data['record']['category_one'] = $_GET['production_summary']['category_one'];
    if (!empty($_GET['production_summary']['machine_size'])) $this->data['record']['machine_size'] = $_GET['production_summary']['machine_size'];
    if (!empty($_GET['production_summary']['design_code']))  $this->data['record']['design_code']  = $_GET['production_summary']['design_code'];

    if (!isset($this->data['record']['product_name']) || $this->data['record']['product_name'] == 'KA Chain') {
      $url=ARF_API_BASE_PATH."issue_departments/api_issue_departments/create";
      $records=json_decode(curl_post_request($url, $this->data['record']));
      $arf_data = json_decode(json_encode($records), true);
    } else {
      $arf_data = array('product_names' => array('names' => array()),
                        'in_purities' => array('names' => array()),
                        'category_ones' => array('names' => array()),
                        'machine_sizes' => array('names' => array()),
                        'design_codes' => array('names' => array()));
    }

    if (!isset($this->data['record']['product_name']) || $this->data['record']['product_name'] != 'KA Chain') {
      $url=API_LIVE_BASE_PATH."issue_departments/api_issue_departments/create";
      $records=json_decode(curl_post_request($url, $this->data['record']));
      $argold_data = json_decode(json_encode($records), true);
    } else {
      $argold_data = array('product_names' => array('names' => array()),
                           'in_purities' => array('names' => array()),
                           'category_ones' => array('names' => array()),
                           'machine_sizes' => array('names' => array()),
                           'design_codes' => array('names' => array()));
    }

    $this->data['product_names'] = get_dropdown_array(array_unique(array_merge($arf_data['product_names']['names'], $argold_data['product_names']['names'])), true);
    $this->data['in_purities']   = get_dropdown_array(array_unique(array_merge($arf_data['in_purities']['names'], $argold_data['in_purities']['names'])), true);
    $this->data['category_ones'] = get_dropdown_array(array_unique(array_merge($arf_data['category_ones']['names'], $argold_data['category_ones']['names'])), true);
    $this->data['machine_sizes'] = get_dropdown_array(array_unique(array_merge($arf_data['machine_sizes']['names'], $argold_data['machine_sizes']['names'])), true);
    $this->data['design_codes']  = get_dropdown_array(array_unique(array_merge($arf_data['design_codes']['names'], $argold_data['design_codes']['names'])), true);
  }

  private function get_production_summary() {
    if (!isset($_GET['production_summary'])) {
      $_GET['production_summary']= array();
      $this->data['records'] = array('data' => array());
      return;
    }
    $this->data['production_summary'] = $_GET['production_summary'];

    $url=API_ARF_BASE_PATH."issue_departments/api_issue_departments/index";
    $records=json_decode(curl_post_request($url, $_GET['production_summary']));
    $arf_records = json_decode(json_encode($records), true);

    $url=API_LIVE_BASE_PATH."issue_departments/api_issue_departments/index";
    $records=json_decode(curl_post_request($url, $_GET['production_summary']));
    $argold_records = json_decode(json_encode($records), true);    

    $this->data['records'] = array('data' => array_merge($arf_records['data'], $argold_records['data']));
  }
}
