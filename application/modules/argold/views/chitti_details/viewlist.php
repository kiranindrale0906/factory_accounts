<?php 
  if(!empty($metal_voucher_details)) {
    //foreach ($packet_nos as $packet_index => $packet_no) { 
    ?>
      <!-- <h6>Packet No :<?=$packet_no ?> </h6>     -->
      <div class="table-responsive" style="font-weight:500">
      <table class="table table-sm table-default">
        <thead>
          <tr>
            <th></th>
            <th>Design Name</th>
            <th class="text-right">Gross</th>
            <th class="text-right">Melting</th>
            <th class="text-right">Wastage</th>
            <th class="text-right">Fine</th>
          </tr>
        </thead>
        <tbody>
          <?php 
            $sum_weight=$sum_fine=0;
            $sr_no=0;
            foreach ($metal_voucher_details as $index => $metal_voucher_detail) {
              //if($packet_no == $metal_voucher_detail['packet_no']) {
                $sum_weight += $metal_voucher_detail['credit_weight'];
                $sum_fine += $metal_voucher_detail['factory_fine']; ?>
                <tr>
                  <td><?= $sr_no+1?></td>
                  <td>
                    <?php
                      $narration = explode(', ', $metal_voucher_detail['narration']);
                      $narration = array_unique($narration);
                      echo implode(', ', $narration);
                    ?>
                  </td>
                  <td class="text-right"><?= $metal_voucher_detail['credit_weight']; ?></td>
                  <td class="text-right"><?= $metal_voucher_detail['chitti_purity'] ?></td>
                  <td class="text-right"><?= four_decimal($metal_voucher_detail['factory_purity'] - $metal_voucher_detail['chitti_purity']) ?></td>
                  <td class="text-right"><?=$metal_voucher_detail['factory_fine'] ?></td>
                </tr>
                <?php $sr_no++; 
              //}
            }
          ?>
          <tr class="bg_gray bold">
            <td>Total</td>
            <td></td>
            <td class="text-right"><?=four_decimal($sum_weight);?></td>
            <td class="text-right"></td>
            <td class="text-right"></td>
            <td class="text-right"><?=four_decimal($sum_fine);?></td>
          </tr>
        </tbody>
      </table>
    </div>
  <?php //} 
} ?>
