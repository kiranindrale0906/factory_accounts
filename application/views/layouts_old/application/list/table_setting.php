<?php
  $controller = $this->router->class;
  $action = $this->router->method;
  $module = $this->_module;
  $order_clear_url =  base_url().$module.'/'.$controller;
?>
<div class="boxrow mb-2">
	<div class="float-right">
		<?php if($action == 'index'){
			$page_details = getTableSettings();
			if(isset($page_details['select_column']) && $page_details['select_column'] == true){
				load_buttons('button', array(
				'icon'=> 'far fa-check',
				'name'=> 'SELECT COLUMN(S)',				
				'class'=> 'btn btn-sm link blue medium', 
				'data-toggle'=> 'modal',
				'data-target'=> '#select_columns_model'
				));
			}
			if(isset($page_details['arrange_column']) && $page_details['arrange_column']  == true){
				load_buttons('anchor', array(
				'icon'=>'fal fa-hand-pointer',
				'name'=>'ARRANGE COLUMN(S)',				
				'class'=>'btn btn-sm link blue medium', 
				'data-toggle'=>'modal',
				'data-target'=>'#arrange_columns_model'
				));
			}
			load_buttons('anchor', array(
			'icon'=>'far fa-broom',
			'name'=>'CLEAR FILTER',
			'type'=>'link',
			'class'=>'btn btn-sm link blue medium',
			'href' => $order_clear_url
			));
		}
		if (isset($show_inline_form) && $show_inline_form === true):
			$this->load->view($controller . '/form', array('controller' => $controller, 'action' => $action));
		endif;?>			
	</div>
</div>