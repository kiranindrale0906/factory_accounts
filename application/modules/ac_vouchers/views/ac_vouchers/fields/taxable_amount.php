<?php 
  if(!empty(get_field_attribute($this->router->class,'taxable_amount'))) :
    load_field('text', array('field' => 'taxable_amount', 'readonly' => $data['readonly'])); 
  endif; 
?>