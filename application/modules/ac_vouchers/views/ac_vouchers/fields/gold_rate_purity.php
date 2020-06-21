<?php 
  if(!empty(get_field_attribute($this->router->class,'gold_rate_purity'))) :
    load_field('text', array('field' => 'gold_rate_purity',
                             'class' => 'autocomplete_list_selection',
                             'data-table'=>'ac_purity',
                             'data-column'=>'purity',
                             'data-list-title'=>'Gold Rate Purity'));                                
  endif; 
?>