<?php 
  if(!empty(get_field_attribute($this->router->class,'sgst_amount'))) :
    load_field('text', array('field' => 'sgst_amount', 'readonly' => $data['readonly'])); 
  endif; 
?>