<?php 
  if(!empty($chitti_details)) {
    //foreach ($packet_nos as $packet_index => $packet_no) { 
    ?>
      <!-- <h6>Packet No :<?=$packet_no ?> </h6>     -->
      <div class="" style="font-weight:500">
      <table class="table table-sm table-default">
        <thead>
          <tr>
            <th class="">Chitti No</th>
            <th class="">Type</th>
            <th class="text-right">Gross Weight</th>
            <th class="text-right">Melting</th>
            <th class="text-right">Fine</th>
            <th class="text-right">Weight</th>
            <th class="text-right"></th>
          </tr>
        </thead>
        <tbody>
          <?php 
            $sum_weight=$sum_credit_weight=$sum_fine=0;
            $sr_no=0;
            foreach ($chitti_details as $index => $chitti_detail) {
                $sum_weight += $chitti_detail['weight'];
                $sum_credit_weight += $chitti_detail['credit_weight'];
                $sum_fine += $chitti_detail['factory_fine'];
               ?>

                <tr>
                  <td><?= ($chitti_detail['id'])?></td>
                  <td><?= ($chitti_detail['sale_type'])?></td>
                  <td class="text-right"><?= four_decimal($chitti_detail['weight']); ?></td>
                  <td class="text-right"><?= four_decimal($chitti_detail['purity']) ?></td>
                  <td class="text-right"><?= four_decimal($chitti_detail['factory_fine']) ?></td>
                  <td class="text-right"><?= four_decimal($chitti_detail['credit_weight']) ?></td>
                  <td class="text-right no-print"><a class='red' href="<?=base_url().'argold/chalan/delete/'.$record['id'].'?chitti_id='.$chitti_detail['id']?>">remove</a></td>
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
            <td class="text-right"><?=four_decimal($sum_fine);?></td> 
            <td class="text-right"><?=four_decimal($sum_credit_weight);?></td> 
          </tr>
        </tbody>
      </table>
    </div>
  <?php //} 
} ?>
