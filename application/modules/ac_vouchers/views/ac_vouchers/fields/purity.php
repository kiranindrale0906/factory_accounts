<?php 
if($this->router->class=='metal_issue_vouchers'){

  if(!empty(get_field_attribute($this->router->class,'purity'))) :
    load_field('dropdown', array('field' => 'purity',
    						 'class'=>'purity',
                             'option'=>$chain_purity)); 
  endif; 
}else{
	if(!empty(get_field_attribute($this->router->class,'purity'))) :
    load_field('text', array('field' => 'purity',
                             'class' => 'autocomplete_list_selection purity',
                             'data-table'=>'ac_purity',
                             'data-column'=>'purity', 
                             'data-list-title'=>'Purity')); 
  endif;

}

?>