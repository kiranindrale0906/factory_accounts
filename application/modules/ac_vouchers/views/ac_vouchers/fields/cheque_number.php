<?php 
  if(!empty(get_field_attribute($this->router->class,'cheque_number'))) :
    load_field('text', array('field' => 'cheque_number'));                     
  endif; 
?>