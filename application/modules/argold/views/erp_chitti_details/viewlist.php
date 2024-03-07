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
            <th class="text-right">Customer Name</th>
            <th class="text-right">Item Code</th>
            <th class="text-right">Gross</th>
            <?php if ($detail==1): ?>
              <th class="text-right">Factory Purity</th>
            <?php endif; ?>
            <th class="text-right">Melting</th>
            <?php if ($this->router->class != 'chitti_domestics'): ?>
            <th class="text-right">Wastage</th>
            <?php endif; ?>
            <!-- <th class="text-right">USD Wastage %</th> -->
            <!-- <th class="text-right">INR Wastage %</th> -->
            <?php if ($detail==1): ?>
              <th class="text-right">Factory Fine</th>
            <?php endif; ?>
            <th class="text-right">Fine</th>
            <?php if ($this->router->class == 'chitti_domestics'){ ?>
            <th class="text-right">Rate</th>
            <th class="text-right">Amount</th>
            <?php } ?>
            <th class="text-right no-print">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php 
            $sum_weight=$sum_fine=$sum_factory_fine=$sum_rate=$sum_rate_amount=0;
            $sr_no=0;
            foreach ($metal_voucher_details as $index => $metal_voucher_detail) {
              if($chittis_details['account_name']=="MALABAR GOLD" && $metal_voucher_detail['chitti_purity']==92){
                $metal_voucher_detail['chitti_purity']=91.80;
              }
              if($chittis_details['account_name']=="MALABAR GOLD" && $metal_voucher_detail['chitti_purity']==75){
              }if($chittis_details['account_name']=="Jewels N Joolry" && $metal_voucher_detail['chitti_purity']==92){
                $metal_voucher_detail['chitti_purity']=91.67;
              }
              //if($packet_no == $metal_voucher_detail['packet_no']) {
                $sum_weight += $metal_voucher_detail['credit_weight'];
                $sum_rate += $metal_voucher_detail['rate'];
                $sum_rate_amount += ($metal_voucher_detail['rate']*$metal_voucher_detail['credit_weight']);
                $sum_fine += $metal_voucher_detail['fine'];
                $sum_factory_fine += $metal_voucher_detail['factory_fine']; ?>

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
                  <td class="text-right"><?= ($metal_voucher_detail['item_code']); ?></td>
                  <td class="text-right"><?= four_decimal($metal_voucher_detail['credit_weight']); ?></td>
                  <?php if ($detail==1): ?>
                    <td class="text-right"><?= four_decimal($metal_voucher_detail['purity']); ?></td>
                  <?php endif; ?>
                  <td class="text-right"><?= four_decimal($metal_voucher_detail['chitti_purity']); ?></td>
                  <?php if ($this->router->class != 'chitti_domestics'): ?>
                  <td class="text-right"><?= four_decimal($metal_voucher_detail['factory_purity'] - $metal_voucher_detail['chitti_purity']) ?></td>
                  <?php endif; ?>
                  <!-- <td class="text-right"><?//= four_decimal($metal_voucher_detail['usd_wastage_percentage']); ?></td>
                  <td class="text-right"><?//= four_decimal($metal_voucher_detail['inr_wastage_percentage']); ?></td>
                   --><?php if ($detail==1): ?>
                    <td class="text-right"><?= four_decimal($metal_voucher_detail['fine']) ?></td>
                  <?php endif; ?>
                  <td class="text-right"><?= four_decimal($metal_voucher_detail['factory_fine']) ?></td>
                  <?php if ($this->router->class == 'chitti_domestics'): ?>
                  <td class="text-right"><?= four_decimal($metal_voucher_detail['rate']) ?></td>
                  <td class="text-right"><?= four_decimal($metal_voucher_detail['rate']*$metal_voucher_detail['credit_weight']) ?></td>
                  <?php endif; ?>
                  <?php if($group_by==0){
                  ?>
                  <td class="text-right no-print"><a class='red' href="<?=base_url().'argold/chitti_erps/delete/'.$record['id'].'?voucher_id='.$metal_voucher_detail['id']?>">remove</a></td>
                  <?php
                }
                ?>
                </tr>
                <?php $sr_no++; 
              //}
            }
          ?>
          <tr class="bg_gray bold">
            <td>Total</td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-right"><?=four_decimal($sum_weight);?></td>
            <td class="text-right"></td>
            <?php if ($this->router->class != 'chitti_domestics'): ?>
            <td class="text-right"></td>
            <?php endif; ?>
            <!-- <td class="text-right"></td>
            <td class="text-right"></td> -->
            <?php if ($detail==1): ?>
              <td class="text-right"></td>
            <?php endif; ?>
            <?php if ($detail==1): ?>
              <td class="text-right"><?=four_decimal($sum_fine);?></td>
            <?php endif; ?>  
            <td class="text-right"><?=four_decimal($sum_factory_fine);?></td>
            <?php if ($this->router->class == 'chitti_domestics'){?>
            <td class="text-right"><?=four_decimal($sum_rate);?></td>
            <td class="text-right"><?=four_decimal($sum_rate_amount);?></td>
            <?php }?>
            <td class="text-right"></td>
          </tr>
        </tbody>
      </table>
    </div>
  <?php //} 
} ?>
