<?php 
  if(!empty(get_field_attribute($this->router->class,'usd_rate'))) :
    load_field('text', array('field' => 'usd_rate')); 
  endif; 
?> 