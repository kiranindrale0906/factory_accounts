<?php 
$add_col_master_name = $this->router->class;

if(isset($filter_columns) && $filter_columns !=''){
  $selected_filter_columns=array_column($filter_columns, 0);  
}
$select_columns_url = getTableSettings($add_col_master_name,@$type,@$type_id);
$current_url = base_url(uri_string());
?>


<div class="modal fade" id="arrange_columns_model" role="dialog">  
  <div class="modal-dialog modal-xl">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg_blue white">
        <h5 class="modal-title">Drag Column Name To Arrange Columns:</h5>

        <?php load_buttons('button', array(
          'icon'=> 'fal fa-times font20',
          'class'=> 'btn btn-lg btn_blue btn_icon', 
          'data-dismiss'=> 'modal'        
        )); ?>
      </div>
      <div class="modal-body">
          <form name="arrange_column_form" id="arrange_column_form_id" method="post" action="<?=$current_url ?>?selected_column=1&ordered_columns=1">
          <div <?php if(sizeof($selected_filter_columns)>10) { ?> style="max-height: 500px;overflow-y: auto;" <?php } ?>>
            <table style="width: 100%;" >
            <tbody id="arrange_column_body">
            <?php if(isset($selected_filter_columns) && $selected_filter_columns !='') { foreach ($selected_filter_columns as $key => $value) { ?>
              <tr>
                <td colspan="2" align="left" class="drag_columns"><input type="hidden" name="ordered_columns[]" value="<?=$value?>" ><?=$value?></td>  
              </tr>
            <?php } } else{?>
            <tr><td>Please select column(s).</td></tr>
            <?php }?>
              </tbody>
              </table>
          </div>
            <hr>
            <?php if(isset($selected_filter_columns) && $selected_filter_columns !='') {?>
              <div>
               <input type="submit" class="btn btn-primary pull-right" value="Submit"/>
              </div>
             <?php }?>
          </form>
      </div>      
    </div>

  </div>
</div>




