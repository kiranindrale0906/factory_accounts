<?php
  if(isset($sales_voucher_id) && $sales_voucher_id != ''):
    if(!empty(@get_field_attribute($this->router->class, 'sales_voucher_number'))): 
      load_field('hidden', array('field' => 'sales_voucher_number',
                                 'value' => @$sales_voucher_id));
    endif;
  endif; 
?>