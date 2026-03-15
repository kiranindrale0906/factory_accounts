<?php 
  if(!empty(get_field_attribute($this->router->class,'add_more'))) :
    load_field('checkbox',  array('field' => 'add_more',
                                  'name' => 'add_more',
                                  'option' => array( array('value' => '1', 
                                                           'checked' => isset($add_more) ? $add_more : '',
                                                           'label' => 'Add More'))));
  endif; 
?>