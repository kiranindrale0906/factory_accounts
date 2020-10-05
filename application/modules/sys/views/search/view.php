<ul class="filterstags">
	<?php $i=1;
		$getDataNewarray = array();
		if(!empty($getData)){
			foreach($getData as $get_key => $getDataValue){
				if(!is_array($getDataValue)){
					$get_keys =  str_replace(array('<=','>=','=','>'), "", $get_key);
					$getDataNewarray[$get_keys][] = $getDataValue;
				}else{
					$getDataNewarray[$get_key][] = $getDataValue;
				}
			}
		}
		foreach($theadColumn as $k => $val):
			if(!empty($getDataNewarray[$val[3]])):
				$show_heading = true;
				if($i == 1)
				echo '<h5 class="mb-0">Filters Applied</h5>';
				if(is_array($getDataNewarray[$val[3]])):
					if(isset($val[9]) && $val[9] == 'daterange'):?>
						<?php if(!empty($getDataNewarray[$val[3]][0]) AND !empty($getDataNewarray[$val[3]][1])){?>
								<li><?= @$val[0] .': '. @date('m/d/Y', strtotime($getDataNewarray[$val[3]][0])).' - '.date('m/d/Y', strtotime($getDataNewarray[$val[3]][1]));?></li>
						<?php }elseif(!empty($getDataNewarray[$val[3]][0])){?>
							  	<li><?= @$val[0] .': '. @date('m/d/Y', strtotime($getDataNewarray[$val[3]][0]));?></li>
						<?php }elseif(!empty($getDataNewarray[$val[3]][1])){?>
							  	<li><?= @$val[0] .': '. @date('m/d/Y', strtotime($getDataNewarray[$val[3]][1]));?></li>
						<?php } ?>
					<?php else:?>
						<?php $my_params = array_unique($getDataNewarray[$val[3]]);
						$j = 0;

						foreach($my_params as $item): 
							if(!is_array($item)){
								if(!empty($item)){?>
								<li>
									<?= @$val[0] .': '. @$item;?>
								</li>
								<?php }
							}else{
								foreach ($item as $item_key => $item_value) {
									if(!empty($item_value)){?>
										<li>
											<?= @$val[0] .': '. @$item_value;?>
										</li>
									<?php }
								}
							} endforeach;?>
				<?php endif;?>
					<?php else:  ?>
					<li>
						<?php 
							if(isset($getDataNewarray[$val[3]]) AND !is_array($getDataNewarray[$val[3]]))
						  		echo $val[0].': '.@$getDataNewarray[$val[3]];
						  else if(isset($getDataNewarray[$val[3]]) AND is_array($getDataNewarray[$val[3]])){ 
						  	foreach ($getDataNewarray[$val[3]] as $get_key => $get_value) {
						  		echo $val[0].': '.$get_value;
						  	}
						  }

						  ?>
					</li>
				<?php endif;
			endif;
			$i++;
		endforeach;?>
</ul> 
