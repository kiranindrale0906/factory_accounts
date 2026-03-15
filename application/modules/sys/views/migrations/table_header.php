

<?php
	echo form_open('',array('method'=>'get'));
	load_buttons('submit', array(
		                 'name'=> 'RUN',
		                 'class'=>'btn-md btn_blue float-right ml-2 update-mogration', 
		                 'href'=> BASE_URL.'sys/migrations/index/run',
		                 'modal-size'=>'lg'
		                ));
	echo '<div class="col-sm-4 pull-right"><input type="text" name="module_name" placeholder="Module Name" class="form-control get_module"></div>';
	 
	 echo form_close();
?>