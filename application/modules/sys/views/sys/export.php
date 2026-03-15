<?php 
	$var = '';
	if( $count > (isset(getTableSettings()['export_limit']) ? getTableSettings()['export_limit']:1000)):
	$var .= '<p>';
		if(isset(getTableSettings()['export_limit'])):
			$var .= 'You have More then'.getTableSettings()['export_limit']. 'data,' ;
		else:	$var .= 'Limit not set for export, You can export 1000 data at a time.';
		endif;
		$var .= 'Please export using links.  Total count of records are '.$count.'</p>';
	else:
		$var .= '<p>Click on link to export sheet, Total count of records are '.$count.'</p>';	
	endif;
	$var .= '<ul class="list-unstyled ">';
		$link_distribution_count = ceil($count / (isset(getTableSettings()['export_limit']) ? 
																										getTableSettings()['export_limit']:1000));
			for ($i=1; $i <= $link_distribution_count; $i++):
				$var .= '<li>';
				$var .=	'<a  href='.base_url().$master_name."/"."index?export=1&&page_no=".$i."&&format=".
							(isset(getTableSettings()['export_format'])?getTableSettings()['export_format']:'xlsx').">";
				$var .=	"Export Excel Sheet ";  
					if($count > (isset(getTableSettings()['export_limit'])?getTableSettings()['export_limit']:1000))
					$var .=	$i; 
					else '';
				$var .=	'</a></li>';		
			endfor;
	$var .= '<li><a  href='.base_url().$master_name.'/index?export=1&&page_no=1&&format=csv>
					Export CSV Sheet</a></li></ul>';
echo $var;
?>	