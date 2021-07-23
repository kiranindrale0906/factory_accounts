<?php 
  if(!empty($metal_voucher_details)) {
    //foreach ($packet_nos as $packet_index => $packet_no) { 
    ?>
      <!-- <h6>Packet No :<?=$packet_no ?> </h6>     -->
      <div class="" style="font-weight:500">
      <table class="table table-sm table-default">
        <thead>
          <tr>
            <th></th>
            <th class="text-right">Gross</th>
            <th class="text-right">Melting</th>
            <th class="text-right">Qauntity</th>
            <th class="text-right">Net weight</th>
            <th class="text-right">Pure</th>
            <th class="text-right">Stone</th>
            <th class="text-right">Making Charge</th>
            <th class="text-right">Category Name</th>
            <th class="text-right">Description</th>
            <th class="text-right">Code</th>
            <th class="text-right">Colour</th>
            <th class="text-right">Total</th>
            <th class="text-right">Site Name</th>
            <th class="text-right no-print">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php 
            $sum_weight=$sum_balance=$sum_total=$sum_net_weight=$sum_pure=$sum_stone=$sum_making_charge=0;
            $sr_no=0;
            foreach ($metal_voucher_details as $index => $metal_voucher_detail) {
              //if($packet_no == $metal_voucher_detail['packet_no']) {
                $sum_weight += $metal_voucher_detail['gross_weight'];
                $sum_net_weight += $metal_voucher_detail['net_weight'];
                $sum_pure += $metal_voucher_detail['pure'];
                $sum_stone += $metal_voucher_detail['stone'];
                $sum_making_charge += $metal_voucher_detail['making_charge'];
                $sum_total += $metal_voucher_detail['total'];
               ?>

                <tr>
                  <td><?= $sr_no+1?></td>
                  <td class="text-right"><?= four_decimal($metal_voucher_detail['gross_weight']); ?></td>
                  <td class="text-right"><?= four_decimal($metal_voucher_detail['purity']) ?></td>
                  <td class="text-right"><?= four_decimal($metal_voucher_detail['quantity']) ?></td>
                  <td class="text-right"><?= four_decimal($metal_voucher_detail['net_weight']) ?></td>
                  <td class="text-right"><?= four_decimal($metal_voucher_detail['pure']) ?></td>
                  <td class="text-right"><?= four_decimal($metal_voucher_detail['stone']) ?></td>
                  <td class="text-right"><?= four_decimal($metal_voucher_detail['making_charge']) ?></td>
                  <td class="text-right"><?= ($metal_voucher_detail['category_name']) ?></td>
                  <td class="text-right"><?= ($metal_voucher_detail['description']) ?></td>
                  <td class="text-right"><?= ($metal_voucher_detail['code']) ?></td>
                  <td class="text-right"><?= ($metal_voucher_detail['colour']) ?></td>
                  <td class="text-right"><?= four_decimal($metal_voucher_detail['total']) ?></td>
                  <td class="text-right"><?= ($metal_voucher_detail['site_name']) ?></td>
                  <td class="text-right no-print"><a class='blue' href="<?=base_url().'argold/metal_issue_packing_slips/edit/'.$metal_voucher_detail['id']?>">edit</a></td>
                  </tr>
                <?php $sr_no++; 
              //}
            }
          ?>
          <tr class="bg_gray bold">
            <td>Total</td>
            <td class="text-right"><?=four_decimal($sum_weight);?></td>
            <td class="text-right"></td> 
            <td class="text-right"></td> 
            <td class="text-right"><?=four_decimal($sum_net_weight);?></td>
            <td class="text-right"><?=four_decimal($sum_pure);?></td> 
            <td class="text-right"><?=four_decimal($sum_stone);?></td> 
            <td class="text-right"><?=four_decimal($sum_making_charge);?></td> 
            <td class="text-right"></td> 
            <td class="text-right"></td>
            <td class="text-right"></td>
            <td class="text-right"></td>
            <td class="text-right"><?=four_decimal($sum_total);?></td>
            <td class="text-right"></td>
            <td class="text-right no-print"></td>
          </tr>
        </tbody>
      </table>
    </div>
  <?php //} 
} ?>
