<?php 
  if(!empty($metal_voucher_details)) {
    //foreach ($packet_nos as $packet_index => $packet_no) { 
    ?>
      <!-- <h6>Packet No :<?=$packet_no ?> </h6>     -->
      <div class="table-responsive" style="font-weight:500">
      <table class="table table-sm table-default">
        <tbody>
          <?php 
            $sum_weight=$sum_fine=$sum_factory_fine=0;
            $sr_no=0;
            foreach ($metal_voucher_details as $index => $metal_voucher_detail) {
              //if($packet_no == $metal_voucher_detail['packet_no']) {?>
                <tr>
                  <th></th>
                  <th>Design Name</th>
                  <th>Customer Name</th>
                  <th class="text-right">Gross</th>
                  <?php if ($detail==1): ?>
                    <th class="text-right">Factory Purity</th>
                  <?php endif; ?>
                  <th class="text-right">Melting</th>
                  <th class="text-right">Wastage</th>
                  <!-- <th class="text-right">USD Wastage %</th> -->
                  <!-- <th class="text-right">INR Wastage %</th> -->
                  <?php if ($detail==1): ?>
                    <th class="text-right">Factory Fine</th>
                  <?php endif; ?>
                  <th class="text-right">Fine</th>
                  <th class="text-right no-print">Action</th>
                </tr>
                <tr>
                  <td><?= $sr_no+1?></td>
                  <td>
                    <?php
                      $narration = explode(', ', $metal_voucher_detail['narration']);
                      $narration = array_unique($narration);
                      $narration = str_replace('Hollow Choco Chain', 'HCC', implode(', ', $narration));
                      $narration = str_replace(['Sisma Chain','Choco Chain'],'', $narration);
                      echo str_replace('HCC', 'Hollow Choco Chain', $narration);
                    ?>
                  </td>
                  <td class="text-right"><?= (!empty($metal_voucher_detail['customer_name'])&& $metal_voucher_detail['customer_name']!='Market Issue')?($metal_voucher_detail['customer_name']):'' ; ?></td>
                  <td class="text-right"><?= four_decimal($metal_voucher_detail['credit_weight']); ?></td>
                  <?php if ($detail==1): ?>
                    <td class="text-right"><?= four_decimal($metal_voucher_detail['purity']); ?></td>
                  <?php endif; ?>
                  <td class="text-right"><?= four_decimal($metal_voucher_detail['chitti_purity']); ?></td>
                  <td class="text-right"><?= four_decimal($metal_voucher_detail['factory_purity'] - $metal_voucher_detail['chitti_purity']) ?></td>
                  <!-- <td class="text-right"><?//= four_decimal($metal_voucher_detail['usd_wastage_percentage']); ?></td>
                  <td class="text-right"><?//= four_decimal($metal_voucher_detail['inr_wastage_percentage']); ?></td>
                   --><?php if ($detail==1): ?>
                    <td class="text-right"><?= four_decimal($metal_voucher_detail['fine']) ?></td>
                  <?php endif; ?>
                  <td class="text-right"><?= four_decimal($metal_voucher_detail['factory_fine']) ?></td>
                  <td class="text-right no-print"><a class='red' href="<?=base_url().'argold/chitti_erps/delete/'.$record['id'].'?voucher_id='.$metal_voucher_detail['id']?>">remove</a></td>
                </tr>
                <?php $sr_no++; 
              //}
            }
          ?>
        </tbody>
      </table>
    </div>
  <?php //} 
} ?>
