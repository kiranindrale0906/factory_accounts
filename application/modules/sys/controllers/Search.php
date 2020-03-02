<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller {
  public function __construct() {
    parent::__construct();
    $this->load->model(array('search_model'));

  }
  
  function index(){// function is used to show popup according to column.
    $module = $this->input->get('module');
    $this->load->helper(array($module.'/'.$_GET['search_url']));
    $data['param']  = $this->input->get();
    $data['values'] = $_SESSION['query_values'];

    $setting_array = $data['param']['function_name']();
    if(isset($data['param']['select_column']) && $data['param']['select_column'] ==1 && $data['param']['ordered_columns'] ==0){
      if(!empty($this->session->userdata('filtered_columns'))){
        foreach($this->session->userdata('filtered_columns') as $seesskey =>$sessvalue){
          foreach ($setting_array as $key => $value) {
            if($key == $sessvalue){
              $newheadings[] =  $value;
            }
          }
        }
        $data['heading'] = $newheadings;
      }
    }
    else if(isset($data['param']['ordered_columns']) && !empty($data['param']['ordered_columns']) == 1){
      if(!empty($this->session->userdata('arranged_columns'))){
        foreach ($this->session->userdata('arranged_columns') as $sesskey => $sessvalue) {
          foreach ($setting_array as $key => $value) {
            if($sessvalue == $value[0]){
              $newheadings[]= $value;
            }
          }
        }
        $data['heading'] = $newheadings;
      }
    }
    else{
      if($data['param']['search_url']=='shared_wr')
         $data['heading'] = $data['param']['function_name']('work');
      else
        $data['heading'] = $data['param']['function_name']();
    } 
    if(!isset($data['heading'])){
      $ci = &get_instance();
      $ci->load->library('listing');
      if(isset($data['param']['dashboard_id']) && $data['param']['dashboard_id']!='')
        $data['heading'] = $ci->listing->getDashboardColumns($data['param']['dashboard_id']);
    }
    $list_function = $data['heading'][$data['param']['key']];

    $data['select_data']='';
    if(isset($list_function[9]) AND ($list_function[9] == 'dynamic_dropdown' 
                          || $list_function[9] =='dynamic_multiselect') AND isset($list_function[10]))
      $data['select_data'] = $this->search_model->getDropdownData($list_function[10],$list_function[1]);//dynamic dropdown
    $data['current_url'] = $data['param']['current_url'].'/';
    $data['search_param'] = $_GET['search_param'];
    if(isset($_GET['query_string']))
      $data['query_string'] = $_GET['query_string'];
    else
      $data['query_string'] = '';

    $json_data = json_encode(array('data'=>$this->load->view('sys/search/index',$data,true),'status'=>'success','open_modal'=>true));
    echo $json_data;
  }//end of index function

  public function getAutoCompleteDropDownData(){ //function is used to get autocomplete data. 
    $li_autocomplete = '';
    $getData = $this->input->get();
    $getDataArray = explode('&&',$getData['query']);
    $autocompleteData = $this->search_model->getAutoCompeleteData($getDataArray[1],
                                        $getDataArray[2],
                                        array(remove_spaces_from_mysql_column($getDataArray[2])
                                              =>remove_spaces_from_value($getDataArray[0])));
    foreach($autocompleteData as $setAutocompleteData){
      if(!empty($setAutocompleteData[$getDataArray[2]]))
        $li_autocomplete[] = $setAutocompleteData[$getDataArray[2]];
    }
    if(empty($setAutocompleteData[$getDataArray[2]]))
      $li_autocomplete[] = 'No suggestion found.';
    echo json_encode($li_autocomplete);
  }
}