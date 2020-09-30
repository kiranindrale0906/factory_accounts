<?php 
  if(!empty(get_field_attribute($this->router->class,'hook_kdm_purity'))) :
    load_field('dropdown', array('field' => 'hook_kdm_purity', 
                                 'option' => get_melting_purity(),
                                 'col' => 'col-md-4'));                     
  endif; 
?>