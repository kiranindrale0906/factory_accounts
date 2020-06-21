<?php 
  if(!empty(get_field_attribute($this->router->class,'cash_bill'))) :
    load_field('text', array('field' => 'cash_bill', 
                             'class' => 'autocomplete_list_selection',
                             'data-table'=>'ac_cash_bill',
                             'data-column'=>'name',
                             'data-list-title'=>'Cash/Bill')); 
  endif; 
?> 