<?php 
  if(!empty(get_field_attribute($this->router->class,'group_name'))) :
    load_field('text', array('field' => 'group_name',
                             'class' => 'autocomplete_list_selection ',
                             'data-table'=>'ac_groups',
                             'data-column'=>'name', 
                             'data-list-title'=>'Group Name'));                                
  endif; 
?>