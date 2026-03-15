<?php
if ($filter_columns != '' && $table_data != '') : ?>
  <tbody>
    <?php if ( ! empty($table_data) && $table_data != '') : ?>

      <?php foreach ($table_data as $index => $value): ?>
        
        <?php 
          if (@$value['reply_status']=='Pending') 
            $css_style = 'background-color:#E8F101; font-weight:bold';
          $alert='';  
          if(($this->router->class=='chittis' || $this->router->class=='chitti_erps') &&(!empty($value['diff_weight']))&&($value['diff_weight']>5 || $value['diff_weight']<-5)){
            $alert='red';
          }
        ?>
        <tr class="<?=$alert?>">
          <?php if ($checkbox_option): ?>
            <td>
              <div class="col-md-2 demo-checkbox">
                <input name="<?= $table_name.'[]' ?>" id="<?= $value['id'] ?>" type="checkbox" value="<?= $value['id'] ?>" class="with-gap radio-col-blue">
                <label for="<?= $value['id'] ?>">
                </label>
              </div>
            </td>
          <?php endif; ?>
          <?php $i=0; 
          foreach ($tablehead as $key => $colum) { ?>
            <?php if ($key == 'action') { ?>
            <td class="text-nowrap action_btn">
              <h6 class="column_heading">Action</h6>                    
              <?= getActions($value, $table_name, $url, $select_url, $filter_details); ?>
            </td>
            <?php } 
            elseif ($key == 'parameter') { ?>
                <td><?= getExplodeParameters(@$value[$key], $key); ?></td>
            <?php 
            }elseif(isset($colum[8]) && !empty($colum[8]) && $colum[8] == 'image' && $colum[8] != 1){
                $image_name = $value[$key];
                //$id = $value['id'];
            ?>
              <td><?= getImageData(@$value[$key],@$colum[9].$image_name, $colum[10]); ?></td>
            <?php 
            }
            /*elseif((isset($colum[9]) && !empty($colum[9]) && $colum[9] == 'daterange' && $colum[9] != 1)){
              if($value[$key] == "0000-00-00" || $value[$key] == ""){
                $date = '00/00/0000';
              }else{
                $date =  date("m/d/Y", strtotime($value[$key]));
              };?>
              <td><h6 class="column_heading"><?php echo $colum[0]; ?></h6> <?php  if($date == '00/00/0000'){echo '';}else{echo $date;}?></td>
            <?php 
            }*/

            else { ?>
              <td class="<?=(!empty($colum[10]))?'text-right':''?>">              
                <h6 class="column_heading"><?php echo $colum[0]; ?></h6>
                <span><?= getColumnData(@$value[$key], $key, @$value['user_id']); ?></span>
              </td>
            <?php } ?>

              <?php $i++;
          } ?>
      
        </tr>
      <?php endforeach; ?>
      <?php $this->load->view('layouts/application/list/tbody_footer');?>
      <?php else: ?>
      <tr>
          <td colspan="12">No Record Found.</td>
      </tr>
    <?php endif; ?>
  </tbody>
<?php 
  else: ?>
  <tbody>
    <tr>
      <td colspan="12">Please Select At least One Column.</td>
    </tr>
  </tbody>
<?php 
endif; ?> 

