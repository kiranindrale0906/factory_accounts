<?php 
  if(!empty($chitti_details)) {
    //foreach ($packet_nos as $packet_index => $packet_no) { 
    ?>
      <!-- <h6>Packet No :<?=$packet_no ?> </h6>     -->
      <div class="" style="font-weight:500">
      <table class="table table-sm table-default">
        <thead>
          <tr>
            <th class="text-right">Chitti No</th>
            <th class="text-right">Gross Weight</th>
            <th class="text-right">Melting</th>
            <th class="text-right">Fine</th>
            <th class="text-right">Weight</th>
          </tr>
        </thead>
        <tbody>
          <?php 
            $sum_weight=$sum_debit_amount=$sum_fine=0;
            $sr_no=0;
            foreach ($chitti_details as $index => $chitti_detail) {
                $sum_debit_amount += $chitti_detail['credit_weight'];
                $sum_weight += $chitti_detail['weight'];
                $sum_fine += $chitti_detail['fine'];
               ?>

                <tr>
                  <td><?= ($chitti_detail['id'])?></td>
                  <td class="text-right"><?= four_decimal($chitti_detail['credit_weight']); ?></td>
                  <td class="text-right"><?= four_decimal($chitti_detail['purity']) ?></td>
                  <td class="text-right"><?= four_decimal($chitti_detail['fine']) ?></td>
                  <td class="text-right"><?= four_decimal($chitti_detail['weight']) ?></td>
                  </tr>
                <?php $sr_no++; 
              //}
            }
          ?>
          <tr class="bg_gray bold">
            <td>Total</td>
            <td class="text-right"><?=four_decimal($sum_debit_amount);?></td>
            <td class="text-right"></td>
            <td class="text-right"><?=four_decimal($sum_fine);?></td> 
            <td class="text-right"><?=four_decimal($sum_weight);?></td> 
          </tr>
        </tbody>
      </table>
    </div>
  <?php //} 
} ?>
