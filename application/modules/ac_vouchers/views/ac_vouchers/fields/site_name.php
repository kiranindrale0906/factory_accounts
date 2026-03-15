<?php
  $site_names = get_site_names();
	if(!empty(get_field_attribute($this->router->class,'site_name'))) :
    load_field('dropdown', array('field' => 'site_name', 
                                 'option' => $site_names,
                                 'class' => 'site_name')); 
  endif; 
?>