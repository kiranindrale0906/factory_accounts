<input type='hidden' name='http_referer' value='<?= isset($http_referer) ? $http_referer : '' ?>' />

<button type="submit" 
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
<?= @$data['icon'];?> <?=@$data['name']?>	
</button>


