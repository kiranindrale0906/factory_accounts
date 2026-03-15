<?php 
  if(!empty(get_field_attribute($this->router->class,'from_account_name'))) :
    load_field('text', array('field' => 'from_account_name',
               'class' => 'autocomplete_list_selection',
               'data-table' => 'ac_account',
               'data-column' => 'name',
               'data-where_condition' => 'group_code=\'bank\'',
               'data-list-title' => 'From Account Name')); 

    load_field('hidden', array('field' => 'from_account_id'));                               
  endif; 
?>