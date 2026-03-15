<?php
  $masters             = array();
  $add_col_master_name = $this->router->class;
  $select_columns_url  = getTableSettings();
  $add_colmns          = array();
 
  $flag = true;
  $custom_url = custom_url_manager('selected_column');
  if (isset($filter_columns) && $filter_columns != '') 
    $selected_filter_columns = array_column($filter_columns, 0);

?>
  <?= form_open(@$custom_url,'id=add_column_form_id','name=add_column_form');?>
    <div>
      <table width="100%">
        <thead>
          <tr>
            <th colspan="6" style="padding: 2px">
              <input type="checkbox"
                    class="selectDeselect" 
                    <?php if (sizeof($table_columns) == sizeof($filter_columns)) { echo 'checked'; } ?> />
                Select/Deselect
            </th>
            <th colspan="6"></th>
          </tr>
        </thead>
        <tbody>
          
          <?php 
          $cnt = 0;
          foreach ($table_columns as $head_key => $columns) : 
            //echo "<pre>";print_r($columns[0]);
            $cnt++;
              if ($cnt % 2 == 1) { 
                echo '<tr>';
            
              }?>    
            <td colspan="6">
              <input type="checkbox" class="add_column_checkbox"
                     name="selected_columns[<?php echo $head_key; ?>]"
                     id="selected_columns[<?php echo $head_key; ?>]" <?= (isset($selected_filter_columns) && in_array($columns[0], $selected_filter_columns)) ? 'checked' : '' ?>
                     value="<?php echo $head_key; ?>"
                     style="padding: 5px; vertical-align: bottom; position: relative; top: -1px; margin: 3px;">

              <span>
                <?php echo $columns[0];?>
              <span>
            </td>
            <?php if ($cnt % 2 == 0 || sizeof($theadColumn) == $cnt) { ?>
              </tr>
            <?php } ?>
          <?php
          endforeach;?>
                         
        </tbody>
      </table>
    </div>
    <hr>
    <div>
      <input type="submit" class="btn btn-primary pull-right <?php if(isset($_GET['is_ajax']) && $_GET['is_ajax'] == 1) echo 'select_column_arrange_column';?>" value="Submit" data-controller='<?php echo $this->router->class;?>'/>
    </div>
  <?= form_close();?>