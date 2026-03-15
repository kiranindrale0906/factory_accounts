
<?php 
if($this->router->class=='metal_issue_vouchers'){
  if(!empty(get_field_attribute($this->router->class,'factory_purity'))) :
    load_field('text', array('field' => 'factory_purity', 
                             'readonly'=>'1', 
                             'class'=>'factory_purity')); 
  endif; 
}else{
	if(!empty(get_field_attribute($this->router->class,'factory_purity'))) :
	$data['readonly']=!empty($refresh_id)?'readonly':'';
    load_field('text', array('field' => 'factory_purity','readonly' =>$data['readonly'],
                             'class' => 'factory_purity')); 
  endif;

}

?>