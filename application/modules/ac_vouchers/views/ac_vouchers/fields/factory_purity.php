<?php 
  if(!empty(get_field_attribute($this->router->class,'factory_purity'))) :
    load_field('text', array('field' => 'factory_purity', 
                             'class'=>'factory_purity'));
  endif; 
?>