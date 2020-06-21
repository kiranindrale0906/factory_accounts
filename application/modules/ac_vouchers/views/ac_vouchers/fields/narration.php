<?php 
  if(!empty(get_field_attribute($this->router->class,'narration'))) :
    load_field('text', array('field' => 'narration',
               'class' => 'autocomplete_list_selection',
               'data-table'=>'ac_narration',
               'data-column'=>'name',
               'data-list-title'=>'Narration')); 
  endif; 
?>