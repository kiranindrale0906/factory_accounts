<?php 
  if(!empty(get_field_attribute($this->router->class,'cgst_amount'))) :
    load_field('text', array('field' => 'cgst_amount', 'readonly' => $data['readonly'])); 
  endif; 
?>