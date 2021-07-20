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
            <th class="text-right">Gross</th>
            <th class="text-right">Melting</th>
            <th class="text-right">Net weight</th>
            <th class="text-right">Pure</th>
            <th class="text-right">Stone</th>
            <th class="text-right">Making Charge</th>
            <th class="text-right">Description</th>
            <th class="text-right">Code</th>
            <th class="text-right">Colour</th>
            <th class="text-right">Total</th>
          </tr>
        </thead>
        <tbody>
          <?php 
            $sum_weight=$sum_total=$sum_net_weight=$sum_pure=$sum_stone=$sum_making_charge=0;
            $sr_no=0;
            foreach ($metal_voucher_details as $index => $metal_voucher_detail) {
              //if($packet_no == $metal_voucher_detail['packet_no']) {
                $sum_weight += $metal_voucher_detail['credit_weight'];
                $sum_net_weight += $metal_voucher_detail['packing_slip_net_weight'];
                $sum_pure += $metal_voucher_detail['packing_slip_pure'];
                $sum_stone += $metal_voucher_detail['packing_slip_stone'];
                $sum_making_charge += $metal_voucher_detail['packing_slip_making_charge'];
                $sum_total += $metal_voucher_detail['packing_slip_total'];
               ?>

                <tr>
                  <td><?= $sr_no+1?></td>
                  <td class="text-right"><?= four_decimal($metal_voucher_detail['credit_weight']); ?></td>
                  <td class="text-right"><?= four_decimal($metal_voucher_detail['purity']) ?></td>
                  <td class="text-right"><?= four_decimal($metal_voucher_detail['packing_slip_net_weight']) ?></td>
                  <td class="text-right"><?= four_decimal($metal_voucher_detail['packing_slip_pure']) ?></td>
                  <td class="text-right"><?= four_decimal($metal_voucher_detail['packing_slip_stone']) ?></td>
                  <td class="text-right"><?= four_decimal($metal_voucher_detail['packing_slip_making_charge']) ?></td>
                  <td class="text-right"><?= four_decimal($metal_voucher_detail['packing_slip_description']) ?></td>
                  <td class="text-right"><?= four_decimal($metal_voucher_detail['packing_slip_code']) ?></td>
                  <td class="text-right"><?= four_decimal($metal_voucher_detail['packing_slip_colour']) ?></td>
                  <td class="text-right"><?= four_decimal($metal_voucher_detail['packing_slip_total']) ?></td>
                  </tr>
                <?php $sr_no++; 
              //}
            }
          ?>
          <tr class="bg_gray bold">
            <td>Total</td>
            <td class="text-right"><?=four_decimal($sum_weight);?></td>
            <td class="text-right"></td> 
            <td class="text-right"><?=four_decimal($sum_net_weight);?></td>
            <td class="text-right"><?=four_decimal($sum_pure);?></td> 
            <td class="text-right"><?=four_decimal($sum_stone);?></td> 
            <td class="text-right"><?=four_decimal($sum_making_charge);?></td> 
            <td class="text-right"></td> 
            <td class="text-right"></td>
            <td class="text-right"></td>
            <td class="text-right"><?=four_decimal($sum_total);?></td>
          </tr>
        </tbody>
      </table>
    </div>
  <?php //} 
} ?>
