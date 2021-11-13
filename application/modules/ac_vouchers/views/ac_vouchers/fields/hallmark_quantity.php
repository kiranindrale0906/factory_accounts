<?php 
  if(!empty(get_field_attribute($this->router->class,'hallmark_quantity'))):
    load_field('text', array('field' => 'hallmark_quantity'));                                
  endif; 
?>