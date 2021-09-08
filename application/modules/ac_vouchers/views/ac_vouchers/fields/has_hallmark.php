<?php 
  if(!empty(get_field_attribute($this->router->class,'has_hallmark'))) :
    load_field('checkbox',  array('field' => 'has_hallmark',
                                  'option' => array( array('value' => '1', 
                                                           'checked'=>TRUE,
                                                           'label' => 'Has Hallmark')),
                                  'checked'=>$checked));

  endif; 
?>