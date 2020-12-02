<?php
  if(!empty(get_field_attribute($this->router->class,'sale_type'))):
    load_field('dropdown', array('field' => 'sale_type', 
                                 'option' => get_sale_types())); 
  endif; 
?>