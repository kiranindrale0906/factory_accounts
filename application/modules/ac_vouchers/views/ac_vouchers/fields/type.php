 <?php 
  if(!empty(get_field_attribute($this->router->class,'type'))) :
    load_field('text', array('field' => 'type',
                             'class' => 'autocomplete_list_selection ',
                             'data-table'=>'ac_type',
                             'data-column'=>'name', 
                             'data-list-title'=>'Type'));                               
  endif; 
?> 