<?php 
$add_col_master_name = $this->router->class;

if(isset($filter_columns) && $filter_columns !=''){
  $selected_filter_columns=array_column($filter_columns, 0);  
}
$current_url = base_url(uri_string());

$link_params = !empty($_SERVER['QUERY_STRING'])?'?'.$_SERVER['QUERY_STRING']:'';

$link_params = str_replace("&selected_column=1&ordered_columns=1","",$link_params);
$link_params = str_replace("&selected_column=1&ordered_columns=0","",$link_params);
$link_params = str_replace("?selected_column=1&ordered_columns=0","",$link_params);
$link_params = str_replace("?arrange_col=1&table_filter=1","",$link_params);
$link_params = str_replace("&is_ajax=1","",$link_params);
$link_params = str_replace("&is_ajax=0","",$link_params);
$new_url = !empty($link_params) ? $link_params.'&selected_column=1&ordered_columns=1' : '?selected_column=1&ordered_columns=1';
$paramCount = substr_count($new_url, "selected_column=1&ordered_columns=1");
if($paramCount>1){
  $new_url = str_replace("&selected_column=1&ordered_columns=1","",$new_url);
}
$paramCount = substr_count($new_url, "selected_column=1&ordered_columns=0");
if($paramCount>1){
  $new_url = str_replace("&selected_column=1&ordered_columns=0","",$new_url);
  $new_url = str_replace("?selected_column=1&ordered_columns=0","",$new_url);
}
?>
<?= form_open(@$current_url.@$param['search_url'].$new_url,'id=arrange_column_form_id','name=arrange_column_form');?>
  <div <?php if(sizeof($selected_filter_columns)>10) { ?> style="max-height: 500px;overflow-y: auto;" <?php } ?>>

    <ul class="list-unstyled" id="arrange_column_body">
    <?php if(isset($selected_filter_columns) && $selected_filter_columns !='') { foreach ($selected_filter_columns as $key => $value) { ?>

      <li colspan="2" align="left" class="drag_columns cursor-move"><input type="hidden" name="ordered_columns[]" value="<?=$value?>" ><?=$value?></li>  

    <?php } } else{?>

      <li>Please select column(s).</li>

    <?php }?>
    </ul>
  </div>
  <hr>
  <?php if(isset($selected_filter_columns) && $selected_filter_columns !='') {?>

  <div>
    <input type="submit" class="btn btn-primary pull-right <?php if(isset($_GET['is_ajax']) && $_GET['is_ajax'] == 1) echo 'select_column_arrange_column';?>" data-controller='<?php echo $this->router->class;?>' value="Submit"/>
  </div>
<?php } 
form_close();?>
