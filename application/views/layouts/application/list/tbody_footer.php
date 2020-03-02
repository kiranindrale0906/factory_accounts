
<tfoot>
  <?php if(!empty($sum)){?>  
    <tr class="mob_hidden">
      <?php
      $head_set = 0;
      foreach ($tablehead as $head_key => $head_value) {
        //echo "$head_value[0]";
        if(isset($head_value[11]) AND $head_value[11] == 'sum'){
          foreach ($sum[0] as $sum_key => $sum_value){
            if($head_key == $sum_key){
              echo '<td><b><span>Sub Total</span></b></td>';
            }
          }
        }else{
          echo '<td><span></span></td>';
          $head_set++;
        }
      } ?>
    </tr> 
    <tr>
      <?php
      $sub_total_sum = 0;
      $head_set = 0;
      foreach ($tablehead as $head_key => $head_value) {
        if(isset($head_value[11]) AND $head_value[11] == 'sum'){
          foreach($table_data as $table_data_key => $table_data_value) $sub_total_sum += $table_data_value[$head_key];
          echo '<td><h6 class="column_heading">'.$head_value[0].' Sub Total</h6> <b><span>'.$sub_total_sum.'</span></b></td>';
        }else {
          echo '<td class="mob_hidden"><span></span></td>'; $head_set++;
        }
        $sub_total_sum = 0;
      }
      ?>
    </tr>
    <tr class="mob_hidden">
      <?php
      $head_set = 0;
      foreach ($tablehead as $head_key => $head_value) {
        if(isset($head_value[11]) AND $head_value[11] == 'sum'){
          foreach ($sum[0] as $sum_key => $sum_value)
            if($head_key == $sum_key) echo '<td><b><span>Total</span></b></td>';
        }else { 
          echo '<td><span></span></td>'; $head_set++;
        }
      } ?>
    </tr>
    <tr>
      <?php
      $head_set = 0;
      foreach ($tablehead as $head_key => $head_value) {
        if(isset($head_value[11]) AND $head_value[11] == 'sum'){
          foreach ($sum[0] as $sum_key => $sum_value)
            if($head_key == $sum_key) echo '<td><h6 class="column_heading">'.$head_value[0].' Total</h6> <b><span>'.$sum_value.'</span></b></td>';
        }else{
          echo '<td class="mob_hidden"><span></span></td>'; $head_set++;
        }
      } ?>
    </tr>
  <?php }?>
</tfoot> 

