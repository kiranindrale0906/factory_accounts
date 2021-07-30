<?php 
  if(!empty($metal_voucher_details)) {
    //foreach ($packet_nos as $packet_index => $packet_no) { 
    ?>
      <!-- <h6>Packet No :<?=$packet_no ?> </h6>     -->
      <div class="" style="font-weight:500">
      <table class="table">
          <tr>
            <?php foreach ($metal_voucher_details as $index => $metal_voucher_detail) {
                   ?>
            <td class="">Tag No.</td>
            <td class="text-center"><?= ($metal_voucher_detail['sr_no']); ?></td>
            
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
            <td class="text-center"><?php
              if($metal_voucher_detail['purity'])>=91.50 && $metal_voucher_detail['purity'])<= 92){
                    echo "22 Kt";
              }elseif($metal_voucher_detail['purity'])>=87.50 && $metal_voucher_detail['purity'])<= 88){
                    echo "21 Kt";
              }elseif($metal_voucher_detail['purity'])>=75 && $metal_voucher_detail['purity'])<= 75.50){
                    echo "18 Kt";
              }elseif($metal_voucher_detail['purity'])>=58 && $metal_voucher_detail['purity'])<= 58.50){
                    echo "14 Kt";
              }elseif($metal_voucher_detail['purity'])>=41 && $metal_voucher_detail['purity'])<= 42){
                    echo "10 Kt";
              }

            ?></td>
            <?php 
            }?>
            </tr><tr><?php
            foreach ($metal_voucher_details as $index => $metal_voucher_detail) {
               ?> 
            
            <td class="">Desc</td>
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