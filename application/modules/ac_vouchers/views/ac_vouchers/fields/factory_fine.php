<?php 
  if(!empty(get_field_attribute($this->router->class,'factory_fine'))) :
    load_field('text', array('field' => 'factory_fine', 
                             'readonlyinput'=>'1', 
                             'class'=>'factory_fine')); 
  endif; 
?>       