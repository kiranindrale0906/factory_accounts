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
            <th>Date</th>
            <th>Narration</th>
            <th class="text-right">Weight</th>
            <th class="text-right">Purity</th>
            <th class="text-right">Fine</th>
            <th class="text-right">Product Rate</th>
            <th class="text-right">Total Amount</th>
            <!-- <th class="text-right no-print">Action</th> -->
          </tr>
        </thead>
        <tbody>
          <?php 
            $sum_weight=$sum_fine=$sum_rate=$sum_factory_fine=$sum_total=0;
            $sr_no=1;
            foreach ($metal_voucher_details as $index => $metal_voucher_detail) {
              //if($packet_no == $metal_voucher_detail['packet_no']) {
                $sum_weight += $metal_voucher_detail['credit_weight'];
                $sum_fine += $metal_voucher_detail['fine'];
                $sum_rate += $metal_voucher_detail['process_rate'];
                $sum_factory_fine += $metal_voucher_detail['factory_fine']; 
                $sum_total += four_decimal($metal_voucher_detail['credit_weight']*$metal_voucher_detail['process_rate']); 
                ?>

                <tr>
                  <td><?=$sr_no; ?></td>
                  <td><?=$metal_voucher_detail['voucher_date']; ?></td>
                  <td>
                    <?php
                      $narration = explode(', ', $metal_voucher_detail['narration']);
                      $narration = array_unique($narration);
                      $narration = str_replace('Hollow Choco Chain', 'HCC', implode(', ', $narration));
                      $narration = str_replace(['Sisma Chain','Choco Chain'],'', $narration);
                      echo str_replace('HCC', 'Hollow Choco Chain', $narration);
                    ?>
                  </td>
                  <td class="text-right"><?= four_decimal($metal_voucher_detail['credit_weight']); ?></td>
                  <td class="text-right"><?= four_decimal($metal_voucher_detail['purity']) ?></td>
                  <td class="text-right"><?= four_decimal($metal_voucher_detail['fine']) ?></td>
                  <td class="text-right"><?= four_decimal($metal_voucher_detail['process_rate']) ?></td>
                  <td class="text-right"><?= four_decimal($metal_voucher_detail['credit_weight']*$metal_voucher_detail['process_rate']) ?></td>
                  <!-- <td class="text-right no-print"><a class='blue' href="<?//=base_url().'argold/metal_issue_packing_slips/edit/'.$metal_voucher_detail['id']?>">edit</a></td> -->
                </tr>
                <?php $sr_no++; 
              //}
            }
          ?>
          <tr class="bg_gray bold">
            <td>Total</td>
            <td></td>
            <td></td>
            <td class="text-right"><?=four_decimal($sum_weight);?></td>
            <td class="text-right"></td>
            <td class="text-right"><?=four_decimal($sum_fine);?></td>
            <td class="text-right"><?=four_decimal($sum_rate);?></td>
            <td class="text-right"><?=four_decimal($sum_total);?></td>
          </tr>
        </tbody>
      </table>
    </div>
  <?php //} 
} ?>
