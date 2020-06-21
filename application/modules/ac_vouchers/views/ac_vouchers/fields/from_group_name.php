<?php 
  if(!empty(get_field_attribute($this->router->class,'from_group_name'))) :
    load_field('text', array('field' => 'from_group_name',
                             'class' => 'autocomplete_list_selection',
                             'data-table'=>'ac_groups',
                             'data-column'=>'name',
                             'data-list-title'=>'From Group Name'));
    load_field('hidden', array('field' => 'from_group_id'));                                
  endif; 
?>