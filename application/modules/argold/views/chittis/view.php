<h5 class="heading">Chitti View</h5>
<div class="row">
<div class="col-md-6 border-right">
    <div class="form-group container">
      <p><h6>AC Code :<?=$account_id?> </h6></p>
      <p><h6>Voucher No :<?=$record['id']?> </h6></p>
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
<style type="text/css">
  @page { 
    margin: 0mm; 
    size: 4in 6in ;
    size: landscape;
  }
</style>


