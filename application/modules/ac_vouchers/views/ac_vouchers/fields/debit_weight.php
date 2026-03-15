<?php 
  if(!empty(get_field_attribute($this->router->class, 'debit_weight'))) :
  	!empty($refresh_id)?$data['readonly']='readonly':'';
    load_field('text', array('field' => 'debit_weight', 
                             'class'=>'debit_weight',
                             'readonly' => $data['readonly'])); 
  endif; 
?> 