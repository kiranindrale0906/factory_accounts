<?php 
  if(!empty(get_field_attribute($this->router->class,'description'))) :
    load_field('text', array('field' => 'description')); 
  endif; 
?> 