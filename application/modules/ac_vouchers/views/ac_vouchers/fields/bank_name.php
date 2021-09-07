<?php 
  if(!empty(get_field_attribute($this->router->class,'bank_name'))) :
    load_field('text', array('field' => 'bank_name',
                             'class'=>'autocomplete_list_selection',
                             'data-table'=>'ac_account',
                             'data-column'=>'name',
                             'data-where_condition'=>'group_code=\'bank\'',
                             'data-list-title'=>'Bank'));                     
  endif; 
?>