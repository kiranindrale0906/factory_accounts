<h5 class="heading noprint">Metal Voucher View</h5>
<div class="row">
<div class="col-md-6 ">
    <div class="form-group container">
      <p><h6>AC Name :<?=$record['account_name']?> </h6></p>
      <p><h6>Voucher No :<?=$record['voucher_number']?> </h6></p>
      <p><h6>Item Name :<?=$record['narration']?> </h6></p>
      <p><h6>Receipt Type :<?=$record['receipt_type']?></h6></p>
      <?php if($record['receipt_type']=='Daily Drawer'){?>
      <p><h6>Daily Drawer Type :<?=$record['dd_type']?></h6></p>
      <?php }?>
    </div>
  </div>
  <div class="col-md-6">
    
    <div class="form-group container">
      <p><h6>Debit Weight :<?=$record['debit_weight']?></h6></p>
      <p><h6>Purity :<?=$record['purity']?></h6></p>
      <p><h6>Fine :<?=$record['fine']?></h6></p>
      <p><h6>Factory Purity :<?=$record['factory_purity']?></h6></p>
      <p><h6>Factory Fine :<?=$record['factory_fine']?></h6></p>
      <p><h6>Date : <?=date('d-m-Y',strtotime($record['created_at']))?></h6></p>
    </div>
  </div>
  
</div>
<hr class="">
<h6 class="heading ">Metal Issue Voucher Details</h6>
<?php
  $this->load->view('voucher_details/viewlist');
?>
<?php  if(!empty($refresh_details)){?>
<hr class="">
<h6 class="heading ">Refresh Details</h6>
<?php
  $this->load->view('voucher_details/refresh_viewlist');
}
?>

