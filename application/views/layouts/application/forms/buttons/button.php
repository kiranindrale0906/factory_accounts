<button 
	type="button"
	<?php
	 	if(!isset($data['class']))
	 		echo 'class'.'='.'"btn btn-sm"';
	 	
	 	foreach ($data as $key => $value) {
	 		if($key == 'class')
	 			echo $key.'='."'".'btn '.$value."'";

		 	if($key !='icon')
		 		echo $key.'='."'".$value."'";
		}			 	
	?>
> 
<i class="<?= @$data['icon'];?>"></i> <?=@$data['name']?>	
</button>
