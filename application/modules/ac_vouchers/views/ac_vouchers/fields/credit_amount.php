<?php 
  if(!empty(get_field_attribute($this->router->class,'credit_amount'))) :
    load_field('text', array('field' => 'credit_amount', 'readonly' => $data['readonly'])); 
  endif; 
?>