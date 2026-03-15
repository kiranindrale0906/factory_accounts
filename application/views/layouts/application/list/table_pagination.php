<?php 
$link_params = !empty($_SERVER['QUERY_STRING'])?'?'.$_SERVER['QUERY_STRING']:'?1=1';
if(isset($_GET['page_no'])):
  $paramCount = substr_count($link_params, "page_no=".$_GET['page_no']);
  if($paramCount >= 1){
    $link_params = str_replace("&page_no=".$_GET['page_no'],"",$link_params);
  }
 $link_params = str_replace('get_html=1','', $link_params); 
endif;
$get_table_settings = getTableSettings();
$limit = (!empty($get_table_settings['limit'])?$get_table_settings['limit']:10);
$current_url = base_url().$this->router->module.'/'.$this->router->class.$link_params;
$page_no = (isset($_GET['page_no'])?$_GET['page_no']:1);
$showing = (($page_no - 1) * $limit) + 1;
$prev_page_id = $page_no - 1;
$next_page_id = $page_no + 1;
$end = (($page_no - 1) * $limit) + $count;

$end_count = $limit * $page_no;
if(isset($_GET['show_all'])) $end_count = $count;
$pages = $count;
$total_pages = ceil($count/$limit);
if($count == 0){
  $showing = 0; $end_count = 0;
}

if($end_count > $count)
{
  $end_count = $count;
}

$current_url = str_replace('get_html=1','1=1', $current_url);
if($this->input->is_ajax_request() == true) $ajax = 1; else $ajax = '';
echo 'Showing '.$showing.' to '.$end_count.' of '.$count.' entries';?> 
<div class="panel-footer sticky_bottom bg_white mt-2 d-flex align-items-center justify-content-center mCustomScrollbar_x_js">
  <div class="d-inline-block mr-2"> 
    <ul class="pagination pagination_blue pagination-sm m-0">
      <?php if($page_no !=1){?>
        <li class="page-item previous" aria-controls="datatable" tabindex="0" id="datatable_previous">
          <a class="page-link <?php echo empty($ajax)?$ajax:'pagination_set';?>" data-controller = "<?php echo $this->router->class;?>" href="<?php echo $current_url;?>&page_no=<?php echo $prev_page_id?>">Previous</a>
        </li>
      <?php }?>

      <?php if($total_pages > 1){
        for($i = min(max($total_pages - 10, 1), max($page_no - 5, 1)); $i <= min( max($page_no + 5,11), $total_pages); $i++){
          ($i==$page_no) ? $class = 'active' : $class = '';?>
            <li class="page-item <?php echo $class; ?>" aria-controls="datatable" tabindex="0">
              <a class="page-link <?php echo empty($ajax)?$ajax:'pagination_set';?>" data-controller = "<?php echo $this->router->class;?>" href="<?php echo $current_url?>&page_no=<?=$i;?>">
                <?=$i;?>
              </a>
            </li>
      <?php }}?>
      <?php if($total_pages != $page_no && $pages !=0){?>
        <li class="page-item next" aria-controls="datatable" tabindex="0" id="datatable_next">
          <a class="page-link <?php echo empty($ajax)?$ajax:'pagination_set';?>" data-controller = "<?php echo $this->router->class;?>" href="<?php echo $current_url?>&page_no=<?php echo $next_page_id;?>">Next</a>
        </li>
      <?php }?>
    </ul>
  </div>
</div>