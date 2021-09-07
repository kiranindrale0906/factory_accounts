<?php
	if(!empty(get_field_attribute($this->router->class, 'voucher_date'))) :
    load_field('date',array('field' => 'voucher_date',
                            'value' => (!empty($record['voucher_date']) ? date('d M Y', strtotime($record['voucher_date'])) : date('d M Y')), 
                            'readonlyinput' => true)); 
  endif; 
?>