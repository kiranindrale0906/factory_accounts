<?php 
  if(!empty(get_field_attribute($this->router->class,'quantity'))) :
    load_field('text', array('field' => 'quantity',  
                             'col'=>'col-md-4 hide_quantity'));                     
  endif; 
?>