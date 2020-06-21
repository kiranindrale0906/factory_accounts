<?php 
  if(!empty(get_field_attribute($this->router->class,'credit_weight'))) :
    load_field('text', array('field' => 'credit_weight', 
                             'class'=>'credit_weight',
                             'readonly' => $readonly)); 
  endif; 
?>