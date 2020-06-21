<?php 
  if(!empty(get_field_attribute($this->router->class,'dd_type'))):
    load_field('dropdown', array('field' => 'type', 
                                 'option' => get_daily_drawer_receipt_type(),
                                 'col' => 'col-md-4 hide_daily_drawer_type'));                     
  endif; 
?> 