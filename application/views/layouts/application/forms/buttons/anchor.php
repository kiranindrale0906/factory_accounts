<a 	 
	<?php 
	 	if(!isset($data['href']))
	 		echo 'href'.'='.'"javascript:void(0);"';

	 	if(!isset($data['class']))
	 		echo 'class'.'='.'"btn btn-sm link"';

	 	if(isset($data['data-controller']))
	 		echo 'data-controller'.'='.'"'.$data['data-controller'].'"';

	 	if(isset($data['data-field']))
	 		echo 'data-field'.'='.'"'.$data['data-field'].'"';

	 	if(isset($data['data-id']))
	 		echo 'data-id'.'='.'"'.$data['data-id'].'"';

	 	if(isset($data['onclick']))
	 		echo 'onclick'.'='.'"'. $data['onclick'].'"';

	 	foreach ($data as $key => $value) {
	 		if($key == 'class')
	 			echo $key.'='."'".'btn '.$value."'";

		 	if($key !='icon')
		 		echo $key.'='."'".$value."'";
		}	 	
	?>
>
	<i class="<?= @$data['icon'];?>"></i>  <?= @$data['name'];?>
</a>

