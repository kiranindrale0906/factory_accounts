<h5 class="heading noprint">Chitti View</h5>
<div class="row">
<div class="col-md-6 ">
    <div class="form-group container">
      <p><h6>AC Code :<?=$chittis_details['account_name']?> </h6></p>
      <p><h6>Packet No :<?=$record['packet_no']?> </h6></p>
    </div>
  </div>
  <div class="col-md-6">
    
    <div class="form-group container">
      <p><h6>Voucher Date : <?=date('d-m-Y',strtotime($record['date']))?></h6></p>
     <p><h6>Chitti Date : <?=date('d-m-Y',strtotime($record['created_at']))?></h6></p>
    </div>
  </div>
  
</div>
<hr class="noprint">
<?php
  $this->load->view('chitti_details/viewlist');
?>
<style type="text/css">

  @page { 
    margin: 0mm; 
    size: 4cm 6cm ;
    size: landscape;
  }
</style>


