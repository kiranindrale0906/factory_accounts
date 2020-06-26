<h5 class="heading">Chitti View</h5>
<div class="row">
<div class="col-md-6 border-right">
    <div class="form-group container">
      <p><h6>AC Code :<?=$record['account_name']?> </h6></p>
      <p><h6>Voucher No :<?=$metal_voucher_details['voucher_number']?> </h6></p>
    </div>
  </div>
  <div class="col-md-6 border-right">
    
    <div class="form-group container">
      <p><h6>Date : <?=date('d-m-Y',strtotime($record['created_at']))?></h6></p>
      <p><h6>Page no :</h6></p>
    </div>
  </div>
  
</div>
<hr>
<?php
  $this->load->view('chitti_details/viewlist');
?>


