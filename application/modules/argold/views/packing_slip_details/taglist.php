<?php 
  if(!empty($metal_voucher_details)) {
    //foreach ($packet_nos as $packet_index => $packet_no) { 
    ?>
      <!-- <h6>Packet No :<?=$packet_no ?> </h6>     -->
      <div class="" style="font-weight:500">
      <table class="">
          <tr>
            <?php foreach ($metal_voucher_details as $index => $metal_voucher_detail) {
                   ?>
            <td class="">Tag No.</td>
            <td class="text-center"><?= ($metal_voucher_detail['id']); ?></td>
            
           <?php 
            }?>
          </tr>
          <tr>
            <?php foreach ($metal_voucher_details as $index => $metal_voucher_detail) {
                   ?>
            <td class="">Gross Wt</td>
            <td class="text-center"><?= four_decimal($metal_voucher_detail['gross_weight']); ?></td>
            
           <?php 
            }?>
          </tr>
          <tr>
            <?php
            foreach ($metal_voucher_details as $index => $metal_voucher_detail) {
               ?> 
            
            <td class="">Net Wt</td>
            <td class="text-center"><?= four_decimal($metal_voucher_detail['net_weight']) ?></td>
             <?php 
            }?>
            </tr><tr><?php
            foreach ($metal_voucher_details as $index => $metal_voucher_detail) {
               ?> 
            
            <td class="">Qty</td>
            <td class="text-center"><?= ($metal_voucher_detail['quantity']) ?></td>
            <?php 
            }?>
            </tr><tr><?php
            foreach ($metal_voucher_details as $index => $metal_voucher_detail) {
               ?> 
            
            <td class="">Karat</td>
            <td class="text-center"><?= four_decimal($metal_voucher_detail['purity']) ?></td>
            <?php 
            }?>
            </tr><tr><?php
            foreach ($metal_voucher_details as $index => $metal_voucher_detail) {
               ?> 
            
            <td class="">Description</td>
            <td class="text-center"><?= ($metal_voucher_detail['description']) ?></td>
         <?php 
            }
          ?>
      </table>
    </div>
  <?php //} 
} ?>
<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
</style>