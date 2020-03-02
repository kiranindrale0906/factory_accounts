<?php
$page_details =  getTableSettings();
$table_name = $page_details['primary_table'];
$checkbox_option = (isset($page_details['checkbox_in_listing']) && !empty($page_details['checkbox_in_listing']));

if ($checkbox_option) {
  $multiselect_controller = $page_details['checkbox_in_listing']['controller'];
  $multiselect_action = $page_details['checkbox_in_listing']['action'];
  $action_url = $GLOBALS['CFG']->base_url().$multiselect_controller.'/'.$multiselect_action;
}

if (!empty($type))
  $filter_details = ''; //@get_page_title($master_name)[$type];
else
  $filter_details = '';
if ($filter_columns != '' && is_array($filter_columns)) {
  $tablehead  = gettableheaders($filter_columns);
  $table_data = getTableData($html, $filter_columns);

} else {
  $tablehead  = gettableheaders($page_details['table_heading']);
  $table_data = getTableData($html, $page_details['table_heading']);
}

$check_image = array('logo');
?>

<?php if ($checkbox_option) { ?>
<form method="post" class="form-horizontal" enctype="multipart/form-data" action="<?= $action_url ?>">
<?php } ?>  
  <table class="table table-sm theme_default table-bordered" id="customTableId">
    <thead class="thead-light" id="myHeader">
      <?php if ($filter_columns != '' && $table_data != '') { ?>
          <tr>
            <?php if ($checkbox_option) { ?>
              <th>
                <?= 'Select Rows' ?>
              </th>
            <?php } ?>
            <?php foreach ($thead as $thkey => $thvalue) { ?>
                <th>
                    <?php echo $thvalue[0] ?>
                    <?php echo $thvalue[1] ?>
                  <?php echo $thvalue[2] ?>
                </th>
            <?php } ?>
          </tr>
      <?php } ?>
    </thead>
      <?php if ($filter_columns != '' && $table_data != '') : ?>
        <tbody>
          <?php if ( ! empty($table_data) && $table_data != '') : ?>

            <?php foreach ($table_data as $index => $value): ?>
              
              <?php 
                // $css_style = 'background-color: none';
                if (@$value['reply_status']=='Pending') 
                  $css_style = 'background-color:#E8F101; font-weight:bold';
              ?>
              <tr>
                <?php if ($checkbox_option): ?>
                  <td>
                    <div class="col-md-2 demo-checkbox">
                      <input name="<?= $table_name.'[]' ?>" id="<?= $value['id'] ?>" type="checkbox" value="<?= $value['id'] ?>" class="with-gap radio-col-blue">
                      <label for="<?= $value['id'] ?>">
                      </label>
                    </div>
                  </td>
                <?php endif; ?>
                
                <?php foreach ($tablehead as $key => $colum) { ?>
                  <?php if ($key == 'action') { ?>
                    <td>                    
                      <?= getActions($value, $table_name, $url, $select_url, $filter_details); ?>
                    </td>
                  <?php } elseif (in_array($key, $check_image)) { ?>
                    <td><img src="<?= get_image_url($key, $value[$key]) ?>" height="100" width="100"></td>
                  <?php } else { ?>
                    <td>
                      <span><?php echo getColumnData(@$value[$key], $key, @$value['user_id']); ?></span>
                    </td>
                  <?php } ?>

                <?php } ?>
            
              </tr>
            <?php endforeach; ?>
            <?php else: ?>
              <tr>
                  <td colspan="12">No Record Found.</td>
              </tr>
          <?php endif; ?>
        </tbody>
      <?php else: ?>
        <tbody>
          <tr>
            <td colspan="12">Please Select At least One Column.</td>
          </tr>
        </tbody>
    <?php endif; ?>
  </table>  
  


<?php if ($checkbox_option) { ?>
  <?php load_buttons('submit', array(
    'name'=>'Submit',
    'class'=>'btn btn-sm link blue medium',     
    'name'=> "<?= $table_name ?>",
    'value' => '1',
    'id' => 'selected_submit',
  )); ?>


</form>
<?php } ?>

