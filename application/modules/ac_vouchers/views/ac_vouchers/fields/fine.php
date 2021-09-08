<?php 
  if(!empty(get_field_attribute($this->router->class,'fine'))) :
    load_field('text', array('field' => 'fine',
                             'readonlyinput'=>'1', 
                             'class'=>'fine')); 
  endif; 
?>      