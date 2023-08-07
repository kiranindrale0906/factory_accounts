<hr>
<!-- <h6 class ='blue'>Metal Receipt Details</h6> -->
<?php if($refresh['metal_receipt_id']==0){?>
<div class="row text-right">
  <div class="col-md-12">
  <a href="<?=ADMIN_PATH.'transactions/metal_receipt_vouchers?refresh_id='.$refresh['id']?>" class='btn bg_blue white'>create metal receipt</a>
  
  </div>
</div>
<?php }?>
<div class="row">
 <div class="col-md-6 ">

    <div class="form-group container">
     <p><h6>Weight :<?=four_decimal($refresh['weight'])?></h6></p>
      <p><h6>Purity :<?=four_decimal($refresh['purity'])?></h6></p>
      <p><h6>Fine :<?=four_decimal($refresh['fine'])?></h6></p>
      <p><h6>Factory Purity :<?=four_decimal($refresh['factory_purity']);?></h6></p>
      <p><h6>Site Name :<?=four_decimal($refresh['site_name']);?></h6></p>
      <p><a href='<?= base_url() ?>argold/voucher_details/view/<?=$record['metal_receipt_id']?>'>view metal receipt voucher</a> </p>
      
     <!-- <p><h6>AC Name :<?=four_decimal($metal_receipt_details['account_name']);?> </h6></p>
      <p><h6>Voucher No :<?=four_decimal($metal_receipt_details['voucher_number']);?> </h6></p>
      <p><h6>Item Name :<?=four_decimal($metal_receipt_details['narration']);?> </h6></p>
      <p><h6>Receipt Type :<?=four_decimal($metal_receipt_details['receipt_type']);?></h6></p>-->
    </div>
  </div> 

  <div class="col-md-6">
    
    <div class="form-group container">
      <p><h6>Factory Fine :<?=four_decimal($refresh['factory_fine']);?></h6></p>
     <p><h6>Rate :<?=four_decimal($refresh['rate']);?></h6></p>
      <p><h6>Manual Taxable amount :<?=four_decimal($refresh['manual_taxable_amount']);?></h6></p>
      <p><h6>Metal Receipt Date : <?=date('d-m-Y',strtotime($refresh['created_at']))?></h6></p>
    </div>
  </div>
  
</div>
<h6 class ='blue'>Refresh Details</h6>
<div class="table-responsive">
  <table class="table table-sm table-default">
    <thead>
      <tr>
        <th></th>
        <th class="">Date</th>
        <th class="text-right">Item Name</th>
        <th class="text-right">Weight</th>
        <th class="text-right">Melting</th>
        <th class="text-right">Fine</th>
        <th class="text-right">Factory Melting</th>
        <th class="text-right">Factory Fine</th>
        <th class="text-right"></th>
      </tr>
    </thead>
    <tbody>
    <?php 
    if(!empty($refresh_details)){
      $sum_weight=$sum_fine=$sum_factory_fine=0;
     foreach ($refresh_details as $index => $refresh_detail) {
      $sum_weight+=$refresh_detail['weight'];
      $sum_fine+=$refresh_detail['fine'];
      $sum_factory_fine+=$refresh_detail['factory_fine'];

      ?>
      <tr>
        <td><?=$index+1?></td>
        <td><?=date('d M Y',strtotime($refresh_detail['created_at']));?></td>
        <td class="text-right"><?=$refresh_detail['item_name'] ?></td>
        <td class="text-right"><?= $refresh_detail['weight']; ?></td>
        <td class="text-right"><?= $refresh_detail['purity'] ?></td>
        <td class="text-right"><?=$refresh_detail['fine'] ?></td>
        <td class="text-right"><?=$refresh_detail['factory_purity'] ?></td>
        <td class="text-right"><?=$refresh_detail['factory_fine'] ?></td>
        <td class="text-right"><a href="<?=ADMIN_PATH.'argold/refresh_details/delete/'.$refresh_detail['id']?>" class='btn bg_blue white'>delete</a></td>
      </tr>

    <?php }?>
      <tr class="bg_gray bold">
    <td>Total</td>
    <td class="text-right"></td>
    <td class="text-right"></td>
    <td class="text-right"><?=four_decimal($sum_weight);?></td>
    <td class="text-right"></td>
    <td class="text-right"><?=four_decimal($sum_fine);?></td>
    <td class="text-right"></td>
    <td class="text-right"><?=four_decimal($sum_factory_fine);?></td>
  </tr>
   <?php } ?>
    </tbody>
  </table>
</div>


<div class="row">
  <div class="col-md-6">
  </div>
  <div class="col-md-6">
    <div class="form-group container">
      <table class="table table-sm">
        <tr>
          <td>Weight</td><td class="text-right"><h6><?=four_decimal($record['debit_weight'])?></h6></td>
        </tr><tr>
          <td>Rate</td><td class="text-right"><h6><?=four_decimal($record['rate'])?></h6></td>
        </tr><tr>
          <td>Taxable Amount</td><td class="text-right"><h6><?=four_decimal($record['taxable_amount'])?></h6></td>
        </tr><tr>
          <td>CGST Amount</td><td class="text-right"><h6><?=four_decimal($record['cgst_amount'])?></h6></td>
        </tr><tr>
          <td>SGST Amount</td><td class="text-right"><h6><?=four_decimal($record['sgst_amount'])?></h6></td>
        </tr><tr>
          <td>Total Amount</td><td class="text-right"><h6><?=four_decimal($record['credit_amount'])?></h6></td>
        </tr>
      </table>
    </div>
  </div>
</div>
