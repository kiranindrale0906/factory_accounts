<?php 
  if(!empty(get_field_attribute($this->router->class,'lumpsum_amount'))) :
    load_field('text', array('field' => 'lumpsum_amount'));                     
  endif; 
?>