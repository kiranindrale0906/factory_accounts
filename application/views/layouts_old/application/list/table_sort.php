<?php 
  if($this->input->is_ajax_request() == true)
    $sort = '&get_html=1&table=1';
  else
    $sort = '';
  if (isset($orderData[urldecode($heading)]) && $orderData[urldecode($heading)] == 'desc'){ ?>
    <a onclick= "sorting('<?php echo $page_url.'&order_column=' 
                  . $heading .'&order_by=asc'.$sort;?>','<?php echo $this->router->class;?>')" href="<?php echo empty($sort)?$page_url."&order_column=" 
                  . $heading.'&order_by=asc':'#';?>"><i class="fas fa-sort-amount-up " aria-hidden="true"></i></a>

  <?php }else if (isset($orderData[urldecode($heading)])){
   ?>
    <a onclick= "sorting('<?php echo $page_url 
                      . '&order_column=' 
                      . $heading 
                      . '&order_by=desc'.$sort?>','<?php echo $this->router->class;?>')" href="<?php echo empty($sort)?$page_url 
                      . '&order_column=' 
                      . $heading 
                      . '&order_by=desc':'#';?>">
      <i class="fas fa-sort-amount-down " aria-hidden="true"></i>
    </a>
  <?php   
  }else{ ?>
    <a onclick="sorting('<?php echo  
                  $page_url 
                  . '&order_column=' 
                  . $heading .'&order_by=asc'.$sort;?>','<?php echo $this->router->class;?>')" href="<?php echo empty($sort)? $page_url 
                  . '&order_column=' 
                  . $heading .'&order_by=asc':'#';?>">
      <i class="fa fa-sort white ajax" aria-hidden="true"></i></a>
 <?php }             
?> 