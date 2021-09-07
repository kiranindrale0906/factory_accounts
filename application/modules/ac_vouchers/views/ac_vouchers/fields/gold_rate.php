<?php 
  if(!empty(get_field_attribute($this->router->class,'gold_rate'))):
    load_field('text', array('field' => 'gold_rate'));                                
  endif; 
?>