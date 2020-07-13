<h5 class="heading noprint">Metal Voucher View</h5>
<div class="row">
<div class="col-md-6 ">
    <div class="form-group container">
      <p><h6>AC Name :<?=$record['account_name']?> </h6></p>
      <p><h6>Voucher No :<?=$record['voucher_number']?> </h6></p>
    </div>
  </div>
  <div class="col-md-6">
    
    <div class="form-group container">
      <p><h6>Melting :<?=$record['purity']?></h6></p>
      <p><h6>Receipt Type :<?=$record['receipt_type']?></h6></p>
    </div>
  </div>
  
</div>
<hr class="">
<?php
  $this->load->view('voucher_details/viewlist');
?>
