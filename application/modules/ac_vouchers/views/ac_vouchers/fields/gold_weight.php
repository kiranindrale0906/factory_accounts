<?php 
  if(!empty(get_field_attribute($this->router->class,'gold_weight'))) :
    load_field('text', array('field' => 'gold_weight',
                             'class' => 'autocomplete_list_selection',
                             'data-table'=>'gold_weight',
                             'data-column'=>'name',
                             'data-list-title'=>'Gold Weight'));                                
  endif; 
?>