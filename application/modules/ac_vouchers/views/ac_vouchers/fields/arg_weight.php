<?php
  if(!empty(get_field_attribute($this->router->class,'arg_weight'))) :
    load_field('text', array('field' => 'arg_weight', 
                             'readonlyinput'=>'1', 
                             'class'=>'arg_weight', 
                             'id'=> 'arg_weight'));  
  endif;  
?>