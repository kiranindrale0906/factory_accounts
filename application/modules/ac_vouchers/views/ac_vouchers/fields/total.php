<?php 
  if(!empty(get_field_attribute($this->router->class,'total_gross_weight'))) :
    load_field('text', array('field' => 'total_gross_weight','readonly'=>'readonly','class'=>'get_total_gross_weight')); 
  endif; 
?>
<?php 
  if(!empty(get_field_attribute($this->router->class,'total_net_weight'))) :
    load_field('text', array('field' => 'total_net_weight','readonly'=>'readonly','class'=>'get_total_net_weight')); 
  endif; 
?>
<?php 
  if(!empty(get_field_attribute($this->router->class,'total_fine_weight'))) :
    load_field('text', array('field' => 'total_fine_weight', 'readonly'=>'readonly', 'class'=>'get_total_fine_weight')); 
  endif; 
?> 
<?php 
  if(!empty(get_field_attribute($this->router->class,'total_amount'))) :
    load_field('text', array('field' => 'total_amount','readonly'=>'readonly','class'=>'get_total_amount')); 
  endif; 
?>