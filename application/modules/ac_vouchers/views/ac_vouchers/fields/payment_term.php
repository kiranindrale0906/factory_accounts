<?php 
  if(!empty(get_field_attribute($this->router->class,'payment_term'))) :
    load_field('text', array('field' => 'payment_term',
               'class' => 'autocomplete_list_selection',
               'data-table'=>'ac_payment_terms',
               'data-column'=>'terms',
               'data-list-title'=>'Payment Term'));                                
  endif; 
?>