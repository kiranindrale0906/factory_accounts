<?php 
  if(!empty($metal_voucher_details)) {
    //foreach ($packet_nos as $packet_index => $packet_no) { 
    ?>
      <!-- <h6>Packet No :<?=$packet_no ?> </h6>     -->
      <div class="" style="font-weight:500">
      <table class="" width="100%"  style="font-size: 11px">
            <?php foreach ($metal_voucher_details as $index => $metal_voucher_detail) {
              
                   ?>
          <tr class='bold'>
            <td class="text-center" style="padding: 1px;">Tag No.</td>
            <td style="padding: 1px" class="text-center">Net Wt</td>
            <td style="padding: 1px" class="text-center">Gross Wt</td>
            <td style="padding: 1px" class="text-center">Karat</td>
            <td style="padding: 1px" class="text-center">Qty</td>
            <td style="padding: 1px">Desc</td>
          </tr>
          <tr>
            <td style="padding: 1px" class="text-center"><?= ($metal_voucher_detail['sr_no']); ?></td>
            <td style="padding: 1px" class="text-center"><?= four_decimal($metal_voucher_detail['gross_weight']); ?></td>
            <td style="padding: 1px" class="text-center"><?= four_decimal($metal_voucher_detail['net_weight']) ?></td>
            <td style="padding: 1px" class="text-center"><?= ($metal_voucher_detail['quantity']) ?></td>
            <td style="padding: 1px" class="text-center"><?php
              if($metal_voucher_detail['purity']>=91.50 && $metal_voucher_detail['purity']<= 92){
                    echo "22 Kt";
              }elseif($metal_voucher_detail['purity']>=87.50 && $metal_voucher_detail['purity']<= 88){
                    echo "21 Kt";
              }elseif($metal_voucher_detail['purity']>=75 && $metal_voucher_detail['purity']<= 75.50){
                    echo "18 Kt";
              }elseif($metal_voucher_detail['purity']>=58 && $metal_voucher_detail['purity']<= 58.50){
                    echo "14 Kt";
              }elseif($metal_voucher_detail['purity']>=41 && $metal_voucher_detail['purity']<= 42){
                    echo "10 Kt";
              }

            ?></td>
            <td style="padding: 1px" ><?= ($metal_voucher_detail['description']) ?></td>
          </tr>
         <?php 
            }
          ?>
      </table>
    </div>
  <?php //} 
} ?>
<style>
table, th, td {
  border: 1px solid #b0b0b0;
  border-collapse: collapse;

}
table {page-break-before: always;}
</style>