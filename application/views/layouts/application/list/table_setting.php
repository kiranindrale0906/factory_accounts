<?php
  $page_details =  getTableSettings();
  $controller = $this->router->class;
  $action = $this->router->method;
  $module = $this->_module;
  $order_clear_url =  base_url().$module.'/'.$controller.'?'.add_inbuilt_url_parameters();

  if($this->input->is_ajax_request() == true) $is_ajax = 1;
  else $is_ajax = 0;
?>
<div class="float-right mb-2">
  <?php if($action == 'index'){
    if(isset($page_details['select_column']) && $page_details['select_column'] == true){
      load_buttons('anchor', array(
        'name'=> 'Select Columns',        
        'data-title'=> 'SELECT COLUMN(S):',       
        'class'=> 'btn-xs link blue medium underline p-0 ajax', 
        'data-toggle'=> 'modal',
        'href'=> base_url().$master_name."?select_col=1&table_filter=1"
      ));
    }
    if(isset($page_details['arrange_column']) && $page_details['arrange_column']  == true){
      load_buttons('anchor', array(
        'name'=>'Arrange Columns',        
        'data-title'=>'DRAG COLUMN NAME TO ARRANGE COLUMNS:',       
        'class'=>'btn-xs link blue medium underline p-0 ajax', 
        'data-toggle'=>'modal',
        'href'=> base_url().$master_name."?arrange_col=1&table_filter=1"
      ));
    }
    if(isset($page_details['clear_filter']) && $page_details['clear_filter'] == true && check_filters()){
      load_buttons('anchor', array(
        'name'=>'Clear Filter',
        'data-title'=>'CLEAR FILTER',
        'type'=>'link',
        'class'=>'btn btn-sm btn_blue radius100',
        'href' => $order_clear_url
      ));
    } 

    if(isset($page_details['show_all']) && $page_details['show_all'] == true){
      if(isset($_GET['show_all'])) $checked = 'checked';
      else $checked = '';  
      echo 'Show All <input type="checkbox" '.$checked.'  onchange=show_all_data("'.base_url().$this->router->module.'/'.$this->router->class.'",this)>';
    }
  }
  if (isset($show_inline_form) && $show_inline_form === true):
    $this->load->view($controller . '/form', array('controller' => $controller, 'action' => $action));
  endif;?>   
</div>   
