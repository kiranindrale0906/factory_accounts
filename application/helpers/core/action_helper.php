<?php

/*************************************************************************
* 
* ASCRA TECHNOLOGIES CONFIDENTIAL
* __________________
* 
*  All Rights Reserved.
* 
* NOTICE:  All information contained herein is, and remains
* the property of Ascra Technologies and its suppliers,
* if any.  The intellectual and technical concepts contained
* herein are proprietary to Ascra Technologies
* and its suppliers and may be covered by U.S. and Foreign Patents,
* patents in process, and are protected by trade secret or copyright law.
* Dissemination of this information or reproduction of this material
* is strictly forbidden unless prior written permission is obtained
* from Ascra Technologies.
*/

function gettableheaders($table_heading) {
  if (is_array($table_heading) && $table_heading != '') {
    $headers = $table_heading;
  } else {
    $headers = $table_heading();
  }
  $headings = array();
  foreach ($headers as $key => $value) {
    $headings[$value[1]] = $value;
  }
  return $headings;
}

function getTableData($tabledata, $table_heading) {
  if (is_array($table_heading) && $table_heading != '') {
    $headingdata = $table_heading;
  } else {
    $headingdata = $table_heading();
  }
  $databaseheading = array();
  $table_record = array();
  foreach ($tabledata as $key1 => $value) {
    foreach ($value as $datafield => $fieldvalue) {
      foreach ($headingdata as $key => $headingdatabasename) {
        $databaseheading[$key] = $headingdatabasename[1];
        if (strlen($fieldvalue) > 50 && $databaseheading[$key] != 'action' && $datafield != 'query' && $datafield != 'random_token') {
            $table_record[$key1][$datafield] = truncateTableColumn($fieldvalue, 150, 80);
        } else if ($headingdatabasename[1] == $datafield) {
            $table_record[$key1][$datafield] = $fieldvalue;
        } else {
            $table_record[$key1][$datafield] = truncateTableColumn($fieldvalue, 150, 80);
        }
      }
      if ($datafield == 'date' && $fieldvalue != '') {
        $table_record[$key1][$datafield] = date('d-m-y', strtotime($fieldvalue));
      }
    }
  }
  return $table_record;
}

function getActions($row, $url, $select_url, $filter) {
  $html = '';
  $ci = &get_instance();
  $controllername = $ci->uri->segment(1);
  $getData = $ci->input->get();
  $row_actions = get_row_actions($row, $url, $select_url, $filter);
  foreach ($row_actions as $key => $options) {
    if ($options['request'] == 'http')
      $html .= getHttpButton($key, $options['url'], $options['class'], $options['confirm_message'], isset($options['target'])? $options['target'] : null);
    if ($options['request'] == 'ajax')
      $html .= getAjaxButton($key, $options['url'], $options['class']);
    if ($options['request'] == 'js')
      $html .= getJsButton($key, $options['url'], $options['class'], $options['confirm_message'], $options['js_function']);
    if ($options['request'] == 'ajax_post')
      $html .= getAjaxPost($key, $options['url'], $options['post_data'], $options['class'], $options['success_function']);
  }
  return $html;
}

function getAjaxPost($title, $href, $post_data, $class='', $success_function='') { 
  $json = json_encode($post_data);
  $html = '<a class="btn btn-sm '.$class.' ajax_post'.'" ';
  $html .= 'href=\''.$href.'\'';
  $html .= 'data-ajax=\''.$json.'\'';
  if (!empty($success_function))
    $html .= ' success_function="'.$success_function.'"';
  $html .= '>'.$title.'</a> ';
  return $html;
}

function getCheckbox($row, $table_name, $url, $select_url, $filter) {
  $html = '';
  $ci = &get_instance();
  $controllername = $ci->uri->segment(1);
  $getData = $ci->input->get();
  if (!$row['status'] == '1') {
      return $html;
  }
  $html .= checkboxRecord($row, $controllername);
  return $html;
}

function checkboxRecord($row, $controllername) {
  $html = '';
  if (!in_array($controllername, array('sales_voucher'))) {
    return;
  }
  if (is_dispatch_created($row['id']) === TRUE) {
    return $html;
  }
  $html .= '<div class="demo-checkbox">
              <input type="checkbox" id="md_checkbox_' . $row['id'] . '" name="repair_voucher_out_ids[' . $row['id'] . ']" class="language filled-in chk-col-light-blue chec" value=' . $row['id'] . '>
              <label for="md_checkbox_' . $row['id'] . '"></label>
           </div>';

  return $html;
}

function getHttpButton($title, $href, $class='', $confirm_message='', $target=null) {
  $html = '<a class="btn btn-xs '.$class.'" ';
  if (!empty($confirm_message))
    $html .= 'onclick="return confirm(\''.$confirm_message.'\')"';
  $html .= 'href="'.$href.'"';
  if($target)
    $html .= 'target="'.$target.'"';
  $html .= '>'.$title.'</a> ';
  return $html;
}

function getAjaxButton($title, $href, $class='btn-default', $data_title= '', $highlight = '') {
  $html = '<a class="btn btn-xs '.$highlight.' '.$class.' ajax"';
  $html .= 'data-toggle="modal"
            data-target="#ajax_modal"
            data-title="'.$data_title.'"
            href="'.$href.'"
            data-url="'.$href.'">'.$title.'</a> ';
  return $html;
}


function getJsButton($title, $href, $class='', $confirm_message='', $js_function='') {
  $html = '<a class="btn btn-xs '.$class.'"';
  if (!empty($confirm_message))
    $html .= 'onclick="return confirm(\''.$confirm_message.'\')"';
  if (!empty($js_function))
    $html .= 'onclick="'.$js_function.'"';
  $html .= 'href="'.$href.'">'.$title.'</a> ';
  return $html;
}

function getColumnData($value, $key, $id = '')
{
  $ci = &get_instance();
  if ($value == 'confirmed' && $value != '') {
      $value = "Confirmed";
  }
  if ($value == 'pending' && $value != '') {
      $value = "Pending";
  }
  if ($value == 'rejected' && $value != '') {
      $value = "Rejected";
  }
  return $value;
}

function getImageData($image, $image_path, $default_image){
  $image_value = '';
  $path_info = pathinfo($image_path);
  $dir_name = @$path_info['dirname'];
  $basename = @$path_info['basename'];
  if(!empty(load_image($dir_name.'/'.$basename))){
    $image_value = load_image($dir_name.'/'.$basename,true);
  }
  $src = $image_value;
  $array = @get_headers($src); 
  $string = $array[0]; 
  if(!empty ( $image_value ) AND !empty($image_path) AND strpos($string, "200")){
      $image = '<img width=60 height=60 src="' . $src. '" />';
  }else{
    $image = '<img width=60 height=60 src="' . $default_image. '" />';
  }
  return $image;
}


function truncateTableColumn($desc, $max_length, $min_length = 50)
{
    $length = strlen($desc);
    if ($length > $max_length) {
        return '<div class="user_summery truncate_js" show="50" toggle-type="link">' . $desc . '</div>';
    } else {
        return $desc;
    }
}

function downloadOptions($controllername,$row){
 $html= '';
 $html .=
         '<form action="'.BASE_URL.$controllername.'/export/'.$row['id'].'" method="post"/>
            <input name="css_option" type="radio" class="with-gap" id="radio_all'.$row['id'].'" style="font-size:0.7rem;" value="all" checked="checked" />
              <label style="font-size:0.7rem;" for="radio_all'.$row['id'].'">All</label>
            <input name="css_option" type="radio" class="with-gap" id="radio_pr'.$row['id'].'" style="font-size:0.7rem;" value="product_wise"/>
              <label style="font-size:0.7rem;" for="radio_pr'.$row['id'].'">Product Wise</label>
            <input name="css_option" type="radio" class="with-gap" id="radio_gd'.$row['id'].'" style="font-size:0.7rem;" value="grade_wise"/>
              <label style="font-size:0.7rem;" for="radio_gd'.$row['id'].'">Grade Wise</label>
            <span><button class="btn btn-link text-success" type="submit" title="Download CSS">Download Css</button></span>
          </form>';
 return $html;
}

function getExplodeParameters($value, $key){
  $keywords = '';
  $json_value = json_decode($value,true);
  if(is_array($json_value)){
    foreach ($json_value as $keyword => $searches){
      if(!is_array($searches) )
      $keywords .=  strtoupper($keyword) . ' : ' . $searches.'<br>';
    }
    return $keywords;
  }else{
    return $value;
  }
}