<?php 
  if(!empty(get_field_attribute($this->router->class,'purity'))) :
    load_field('text', array('field' => 'purity',
                             'class' => 'autocomplete_list_selection purity',
                             'data-table'=>'ac_purity',
                             'data-column'=>'purity', 
                             'data-list-title'=>'Purity')); 
  endif; 
?>