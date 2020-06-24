<?php 
  if(!empty(get_field_attribute($this->router->class,'interest_per_day'))) :
    load_field('text', array('field' => 'interest_per_day'));
  endif; 
?>