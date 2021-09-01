<?php 
  if(!empty($metal_voucher_details)) {
    //foreach ($packet_nos as $packet_index => $packet_no) { 
    ?>
      <!-- <h6>Packet No :<?=$packet_no ?> </h6>     -->
      <div class="" style="font-weight:500">
      <table class="" width="100%"  style="font-size: 11px">
            <?php foreach ($metal_voucher_details as $index => $metal_voucher_detail) {

                   ?>
          <tr>
            <td class="" style="padding: 2px;">Tag No.</td>
            <td style="padding: 2px" class="text-center"><?= ($metal_voucher_detail['sr_no']); ?></td>
            
          </tr>
          <tr>
            <td style="padding: 2px" class="">Gross Wt</td>
            <td style="padding: 2px" class="text-center"><?= four_decimal($metal_voucher_detail['gross_weight']); ?></td>
            
            
          </tr>
          <tr>
            <td style="padding: 2px" class="">Net Wt</td>
            <td style="padding: 2px" class="text-center"><?= four_decimal($metal_voucher_detail['net_weight']) ?></td>
          </tr>
           <?php 
            }?>
          <tr>
            <?php foreach ($metal_voucher_details as $index => $metal_voucher_detail) {
                   ?>
            <td style="padding: 2px" class="">Gross Wt</td>
            <td style="padding: 2px" class="text-center"><?= four_decimal($metal_voucher_detail['gross_weight']); ?></td>
            
           <?php 
            }?>
          </tr>
          
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