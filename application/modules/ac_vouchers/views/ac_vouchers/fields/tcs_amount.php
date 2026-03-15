<?php 
  if(!empty(get_field_attribute($this->router->class,'tcs_amount'))) :
    load_field('text', array('field' => 'tcs_amount', 'readonly' => $data['readonly'])); 
  endif; 
?>