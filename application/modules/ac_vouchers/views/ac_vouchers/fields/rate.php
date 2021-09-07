<?php 
  if(!empty(get_field_attribute($this->router->class,'rate'))) :
    load_field('text', array('field' => 'rate',
                             'data-list-title'=>'Rate'));                                
  endif; 
?>