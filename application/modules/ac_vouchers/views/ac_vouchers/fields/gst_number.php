<?php 
  if(!empty(get_field_attribute($this->router->class,'gst_number'))) :
    load_field('text', array('field' => 'gst_number'));                                
  endif; 
?>