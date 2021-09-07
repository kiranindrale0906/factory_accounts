<?php 
  if(!empty(get_field_attribute($this->router->class,'amount'))) :
    load_field('text', array('field' => 'amount')); 
  endif; 
?> 