<?php 
  if(!empty(get_field_attribute($this->router->class,'department_name'))) :
    load_field('text', array('field' => 'department_name',
                             'class' => 'autocomplete_list_selection ',
                             'data-table'=>'ac_department',
                             'data-column'=>'name', 
                             'data-list-title'=>'Department Name')); 
  endif; 
?>