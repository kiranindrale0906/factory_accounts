<?php 
  if(!empty(get_field_attribute($this->router->class,'factory_fine'))) :
!$data['readonly']=!empty($refresh_id)?'readonly':'';
    load_field('text', array('field' => 'factory_fine', 
                             'readonlyinput'=>$data['readonly'], 
                             'class'=>'factory_fine')); 
  endif; 
?>       