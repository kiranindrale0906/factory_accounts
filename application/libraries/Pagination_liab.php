<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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

class Pagination_liab {
  public function __construct() {
    $this->ci = & get_instance();
    $this->ci->load->helper('url');
    $this->ci->load->library(array('pagination'));
    $this->current_site = $_SERVER['REQUEST_URI'];
  }

  public function Create_link($model_name,$function_name,$pagination,$route_url){
    $limit_per_page =($pagination['limit_per_page']) ? $pagination['limit_per_page'] : 10;
    $uri_segment =($pagination['uri_segment']) ? $pagination['uri_segment'] : 3;
    $num_links =($pagination['num_links']) ? $pagination['num_links'] : 2;
    $firstlink =($pagination['firstlink']) ? $pagination['firstlink'] : false;
    // init params
    $params = array();
    $page = ($this->ci->uri->segment($uri_segment)) ? ($this->ci->uri->segment($uri_segment) - 1) : 0;
    $total_records = count($this->ci->$model_name->$function_name());

    $params["results"] = $this->ci->$model_name->$function_name($limit_per_page, $page*$limit_per_page);
    $params['start']=$page * $limit_per_page;
    $config['base_url'] = BASE_URL.$route_url;
    $config['total_rows'] = $total_records;
    $config['per_page'] = $limit_per_page;
    $config["uri_segment"] = $uri_segment;
     
    $config['num_links'] = $num_links;
    $config['use_page_numbers'] = TRUE;
    $config['reuse_query_string'] = TRUE;
     
    $config['full_tag_open'] = '<div class="pagination">';
    $config['full_tag_close'] = '</div>';

     if ($firstlink ==true) {
        $config['first_link'] = 'First Page';
        $config['first_tag_open'] = '<span class="firstlink">';
        $config['first_tag_close'] = '</span>';
         
        $config['last_link'] = 'Last Page';
        $config['last_tag_open'] = '<span class="lastlink">';
        $config['last_tag_close'] = '</span>';
     }
     
    $config['next_link'] = 'Next Page';
    $config['next_tag_open'] = '<span class="nextlink">';
    $config['next_tag_close'] = '</span>';

    $config['prev_link'] = 'Prev Page';
    $config['prev_tag_open'] = '<span class="prevlink">';
    $config['prev_tag_close'] = '</span>';

    $config['cur_tag_open'] = '<span class="curlink">';
    $config['cur_tag_close'] = '</span>';

    $config['num_tag_open'] = '<span class="numlink">';
    $config['num_tag_close'] = '</span>';
    $this->ci->pagination->initialize($config);
    $params["links"] = $this->ci->pagination->create_links();
    return $params;
  }
}
?>