<?php 
  if(!empty(get_field_attribute($this->router->class,'transaction_type'))) :
    load_field('text', array('field' => 'transaction_type', 
                             'class' => 'autocomplete_list_selection',
                             'data-table'=>'ac_cash_bill',
                             'data-column'=>'name',
                             'data-list-title'=>'Transaction Type'));                                
  endif; 
?>