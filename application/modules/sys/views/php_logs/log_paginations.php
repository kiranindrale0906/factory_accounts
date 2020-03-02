<?php 
  $pages = $count;
  parse_str($_SERVER['QUERY_STRING'],$get_array);
  $date = (isset($get_array['date'])?'date='.$get_array['date']:'');
  $current_url = base_url().'sys/php_logs/view?'.$date ;
  $page_no = (isset($_GET['page_no'])?$_GET['page_no']:1);
  $total_pages = round($count/$limit);
  $showing = (($page_no - 1) * $limit) + 1;
  $prev_page_id = $page_no - 1;
  $next_page_id = $page_no + 1;
  $end = (($page_no - 1) * $limit) + $count;
  $end_count = $limit * $page_no;
  ?>
  <?php echo 'Showing '.$showing.' to '.$end_count.' of '.$count.' entries';?>
  <div class="panel-footer sticky_bottom bg_white mt-2 d-flex align-items-center justify-content-center mCustomScrollbar_x_js">
    <div class="d-inline-block mr-2"> 
      <ul class="pagination pagination_blue pagination-sm m-0">
        <?php if(isset($_GET['page_no']) && $_GET['page_no'] !=1){?>
          <li class="page-item previous" aria-controls="datatable" tabindex="0" id="datatable_previous">
            <a class="page-link" data-controller = "<?php echo $this->router->class;?>" href="<?php echo $current_url;?>&page_no=<?php echo $prev_page_id?>">Previous</a>
          </li>
        <?php }?>

        <?php if($pages > 1){
          $show_min = min( $page_no + 9, $pages);
          
          for($i = $page_no; $i <= $show_min; $i++){
            if($i <= $total_pages){
              ($i==$page_no) ? $class = 'active' : $class = '';
              ?>
                <li class="page-item <?php echo $class; ?>" aria-controls="datatable" tabindex="0">
                  <a class="page-link" data-controller = "<?php echo $this->router->class;?>" href="<?php echo $current_url?>&page_no=<?=$i;?>">
                    <?=$i;?>
                  </a>
                </li>
              <?php 
            }
          }
        }?>

        <?php if($pages != $page_no && $pages !=0){?>
          <li class="page-item next" aria-controls="datatable" tabindex="0" id="datatable_next">
            <a class="page-link " data-controller = "<?php echo $this->router->class;?>" href="<?php echo $current_url?>&page_no=<?php echo $next_page_id;?>">Next</a>
          </li>
        <?php }?>
      </ul>
    </div>
  </div>