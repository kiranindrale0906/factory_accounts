<h5 class="heading noprint">Chitti #<?= $record['id']; ?></h5>
<!-- <div class="row">
  <div class="col-md-6 ">
    <div class="form-group container">
      <p><h6>AC Code :<?=$chittis_details['account_name']?> </h6></p>
      <p><h6>Total Gross :<?=four_decimal($record['weight'])?> </h6>
        <h6>Total Fine :<?=four_decimal($record['factory_fine'])?> </h6></p>
      </div>
  </div>
  <div class="col-md-6">
    <div class="form-group container">
      <p><h6>Voucher Date : <?=date('d-m-Y',strtotime($record['date']))?></h6></p>
     <p><h6>Chitti Date : <?=date('d-m-Y',strtotime($record['created_at']))?></h6></p>
    </div>
  </div>
</div> -->

<div class="row">
  <div class="col-md-6">
    <table class="table table-sm">
      <tr>
        <td><h6>Account Name</td><td class="text-right"><?=$chittis_details['account_name']?></h6></td>
      </tr><tr>
        <td><h6>Chitti Date</td><td class="text-right"><?=date('d-m-Y',strtotime($record['created_at']))?></h6></td>
    </table>
  </div>
</div>  
<div class="row">
  <div class="col-md-6">
    <table class="table table-sm">
      <tr>
        <td><h6>Total Gross</td><td class="text-right"><?=four_decimal($record['weight'])?></h6></td>
      </tr><tr>
        <td><h6>Total Fine</td><td class="text-right"><?=four_decimal($record['factory_fine'])?></h6></td>
      </tr>
    </table>
  </div>
  
    <div class="col-md-6">
      <table class="table table-sm">
        <tr>
          <td><h6>No of Packets</td><td class="text-right"><?=four_decimal($record['no_of_packets'])?></h6></td>
        </tr><tr>
          <td><h6>Packet Gross Weight</td><td class="text-right"><?=four_decimal($record['packet_gross_weight'])?></h6></td>
        </tr>
      </table>
    </div>
  </div>
</div>

<hr class="noprint">


<div class="col-md-12">
  <?php $this->load->view('chitti_details/viewlist'); ?>
</div>

<div class="row">
  <div class="col-md-6">
  </div>
  <div class="col-md-6">
    <div class="form-group container">
      <table class="table table-sm">
        <tr>
          <td><h6>Weight</td><td class="text-right"><?=four_decimal($record['credit_weight'])?></h6></td>
        </tr><tr>
          <td><h6>Rate</td><td class="text-right"><?=four_decimal($record['rate'])?></h6></td>
        </tr><tr>
          <td><h6>Taxable Amount</td><td class="text-right"><?=four_decimal($record['taxable_amount'])?></h6></td>
        </tr><tr>
          <td><h6>CGST Amount</td><td class="text-right"><?=four_decimal($record['cgst_amount'])?></h6></td>
        </tr><tr>
          <td><h6>SGST Amount</td><td class="text-right"><?=four_decimal($record['sgst_amount'])?></h6></td>
        </tr><tr>
          <td><h6>Total Amount</td><td class="text-right"><?=four_decimal($record['debit_amount'])?></h6></td>
        </tr>
      </table>
    </div>
  </div>
</div>

<style type="text/css">

  @page { 
    margin: 0mm; 
    size: 4cm 6cm ;
    size: landscape;
  }
</style>


