<?php

if (!function_exists('createHeading')) {
	function createHeading($heading=array(),$new_order=''){
		$html = '';
		if(!empty($heading)){
			$html.='<tr role="row">';
			foreach ($heading as $key => $value) {
				if($value['sort'])
					$html.='<th><a onclick="sortTable(\''.$new_order.'\',\''.$value['sort_field'].'\');" id="ascsort" class="fa fa-sort asc customsort"></a> &nbsp; <a onclick="open_search_form(\'auth_popup\',\'search\',\''.$key.'\');"" id=""class="fa fa-search" aria-hidden="true" ></a><span class="tabletitle">'.$value["name"].'</span></th>';
				else
					$html.='<th><span class="tabletitle">'.$value["name"].'</span></th>';
			}
			$html.='</tr>';
		}
		return $html;
	}
}


if (!function_exists('StatusType')) {
    function StatusType() {
        $result = array(
            "" => "Select Status Type",
            "Enabled" => "Enabled",
            "Disabled" => "Disabled",
        );
        return $result;
    }
}


if (!function_exists('ProfileStatus')) {

    function ProfileStatus() {
        $result = array(
            "" => "Select Profile Status ",
            "draft" => "Draft",
            "published" => "Published",
            "sent for approval" => "Sent for approval",
        );
        return $result;
    }
}

if (!function_exists('yesNo')) {
	function yesNo(){
	    return array(
	        "" => "Select", 
	        "Yes" => "Yes", 
	        "No" => "No", 
	    );
	}
}
?>








