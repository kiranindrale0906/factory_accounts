<?php
    if($this->router->method == 'index')
      $page_details = @getTableSettings();
    else
      $page_details = array();
  ?>

<div class="boxrow mb-2">
  <div class="float-left">
    <?php  
          $create_title = get_form_title($this->router->class, $this->router->method);
          $page_heading = @$page_details['page_title'];
        ?>
        <h6 class="heading blue bold text-uppercase mb-0"><?= @$page_heading; ?></h6>
  </div>
  <div class="float-right">
  	<?php if ($master_name != '') :
  		$page_details = getTableSettings();

      $this->_module = $this->router->fetch_module();
      $create_url = base_url().$this->_module.'/'.$this->router->class."/create"; 

      if (!empty($page_details['create_id']))
        $create_url .= '/'.@$_GET[$page_details['create_id']];

      $query_string = $_SERVER['QUERY_STRING'];

      $export_url = base_url().$master_name."?export=1&".$query_string; 
   
	    if (!empty($page_details['export_title'])) { 
		    load_buttons('anchor', array(
                    'name'=> $page_details['export_title'],                    
                    'class'=>'btn btn-sm btn_blue ajax',              
                    'href'=>$export_url
		                ));
		  }
		  
		  if (!empty($page_details['import_title'])) { 
		  	load_buttons('anchor', array(
	                    'name'=> $page_details['import_title'],                    
	                    'class'=>'btn btn-sm btn-primary',         
	                    'href'=>base_url().$master_name."/create?import=1"
		                ));
      }			

      if (!empty($page_details['add_method']) AND !empty($page_details['add_title'])) {
    		load_buttons('anchor', array(
                    'name'=> $page_details['add_title'],                    
                    'class'=>'btn btn-sm btn-primary',
                    'data-toggle'=>"modal",
                    'data-target'=>"#myModal",
                    'onclick' => 'ajax_get_request(\'' 
        													. $create_url . '\',\'' . $page_details['add_title']. '\');',                  
                    'href'=>"javascript:void(0);"
	                ));
      } 
      if (empty($page_details['add_method']) AND !empty($page_details['add_title'])) {
        load_buttons('anchor', array(
                    'name'=> $page_details['add_title'],                    
                    'class'=>'btn btn-sm btn_blue',
                    'href'=>$create_url
                  ));

      }
      if (!empty($page_details['chitti_hides'])  && empty($_GET['chitti_hides'])) {
        $url=base_url().$master_name.'?chitti_hides=1';
        load_buttons('anchor', array(
                    'name'=> 'Hidden Chittis',                    
                    'class'=>'btn btn-sm btn_blue',
                    'href'=>$url
                  ));

      }
       if (!empty($page_details['chitti_hides']) && !empty($_GET['chitti_hides'])) {
        $url=base_url().$master_name.'?chitti_hides=0';
        load_buttons('anchor', array(
                    'name'=> 'Show Chittis',                    
                    'class'=>'btn btn-sm btn_blue',
                    'href'=>$url
                  ));

      }


      if (isset($page_details['bar_code']) && $page_details['bar_code'] == true && isset($page_details['bar_code_field']) AND !empty($page_details['bar_code_field'])) {
       $url = get_url();
       if(strstr($url,'?') == true){
          $redirect_url = $url.'&bar_code=1&field='.$page_details['bar_code_field'].'&controller='.$this->router->class.'&module='.$this->router->module;
       }else{
          $redirect_url = $url.'?bar_code=1&field='.$page_details['bar_code_field'].'&controller='.$this->router->class.'&module='.$this->router->module;
       }

      load_buttons('anchor', array(
                    'name'=> 'Genrate Bar Codes',                    
                    'class'=>'btn btn-sm btn_blue',
                    'href'=>$redirect_url
                  ));

      }
      endif; ?>
  </div>
</div>