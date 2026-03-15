<?php if(!empty($empty_packet_details)) { ?>
<h5 class="no-print">Empty Packet Details: </h5>
      <table class="table table-sm table-default no-print">
        <thead>
          <tr>
            <th></th>
            <th class="text-right no-print">Weight</th>
            <th class="text-right no-print">Quantity</th>
          </tr>
        </thead>
        <tbody>
          <?php 
            $sum_weight=$sum_fine=$sum_factory_fine=0;
            $sr_no=0;
            foreach ($empty_packet_details as $index => $empty_packet_detail) {
                $sum_weight += $empty_packet_detail['weight'];

                ?>

                <tr>
                  <td><?= $sr_no+1?></td>
                  <td class="text-right"><?= four_decimal($empty_packet_detail['weight']); ?></td>
                  <td class="text-right"><?= four_decimal($empty_packet_detail['quantity']); ?></td>
                </tr>
                 
           <?php  }
          ?>
          <tr class="bg_gray bold">
            <td>Total</td>
            <td class="text-right"><?=four_decimal($sum_weight);?></td>
            <td class="text-right"></td>
            </tr>
        </tbody>
      </table>
  <?php } ?>