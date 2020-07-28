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
    $url=ARF_API_BASE_PATH."issue_departments/api_issue_departments/create";
    $records=json_decode(curl_post_request($url));
    $data = json_decode(json_encode($records), true);

    $this->data['product_names'] = get_dropdown_array($data['product_names']['names'], true);
    $this->data['category_ones'] = get_dropdown_array($data['category_ones']['names'], true);
    $this->data['machine_sizes'] = get_dropdown_array($data['machine_sizes']['names'], true);
    $this->data['design_codes']  = get_dropdown_array($data['design_codes']['names'], true);
    $this->data['in_purities']   = get_dropdown_array($data['in_purities']['names'], true);
  }

  private function get_production_summary() {
    if (!isset($_GET['production_summary'])) {
      $_GET['production_summary']= array();
      $this->data['records'] = array('data' => array());
      return;
    }
    $this->data['production_summary'] = $_GET['production_summary'];
    
    $url=ARF_API_BASE_PATH."issue_departments/api_issue_departments/index";
    $records=json_decode(curl_post_request($url, $_GET['production_summary']));
    $arf_records = json_decode(json_encode($records), true);

    $url=ARF_API_BASE_PATH."issue_departments/api_issue_departments/index";
    $records=json_decode(curl_post_request($url, $_GET['production_summary']));
    $argold_records = json_decode(json_encode($records), true);    

    $this->data['records'] = array('data' => array_merge($arf_records['data'], $argold_records['data']));
  }
}
