<?php 
  if(!empty(get_field_attribute($this->router->class,'to_group_name'))) :
    load_field('text', array('field' => 'to_group_name', 
                             'data-table'=>'ac_groups',
                             'class' => 'autocomplete_list_selection',
                             'data-column'=>'name','col'=>$col,
                             'data-list-title'=>'To Group Name')); 
    load_field('hidden', array('field' => 'to_group_id'));                               
  endif; 
?>