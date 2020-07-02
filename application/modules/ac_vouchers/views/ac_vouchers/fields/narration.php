<?php 
if($this->router->class=='metal_issue_vouchers'
   || $this->router->class=='metal_receipt_vouchers'){
  if(!empty(get_field_attribute($this->router->class,'narration'))) :
    load_field('dropdown', array('field' => 'narration', 
                            'option'=>$narrations)); 
  endif; 
}else{
	 if(!empty(get_field_attribute($this->router->class,'narration'))) :
    load_field('text', array('field' => 'narration',
               'class' => 'autocomplete_list_selection',
               'data-table'=>'ac_narration',
               'data-column'=>'name',
               'data-list-title'=>'Narration')); 
  endif; 
}

?>