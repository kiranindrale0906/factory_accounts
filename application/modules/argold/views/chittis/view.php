<h5 class="heading noprint"><?= $record['sale_type'].' Chitti'?> #<?= $record['id']; ?></h5>
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
        <td>Account Name</td><td class="text-right"><h6><?=$chittis_details['account_name']?></h6></td>
      </tr><tr>
        <td>Chitti Date</td><td class="text-right"><h6><?=date('d-m-Y',strtotime($record['created_at']))?></h6></td>
    </table>
  </div>
</div>  
<div class="row">
  <div class="col-md-6">
    <table class="table table-sm">
      <tr>
        <td>Total Gross</td><td class="text-right"><h6><?=four_decimal($record['weight'])?></h6></td>
      </tr><tr>
        <td>Total Fine</td><td class="text-right"><h6><?=four_decimal($record['factory_fine'])?></h6></td>
      </tr>
    </table>
  </div>
  
    <div class="col-md-6">
      <table class="table table-sm">
        <tr>
          <td>No of Packets</td><td class="text-right"><h6><?=four_decimal($record['no_of_packets'])?></h6></td>
        </tr><tr>
          <td>Packet Gross Weight</td><td class="text-right"><h6><?=four_decimal($record['packet_gross_weight'])?></h6></td>
        </tr>
      </table>
    </div>
  </div>
</div>

<hr class="noprint">


<div class="col-md-12">
  <?php $this->load->view('chitti_details/viewlist'); ?>
</div>

<?php 
  if ($record['sale_type'] == 'Labour')
    $gst_rate = 2.5;
  else
    $gst_rate = 1.5;
?>
<div class="row">
  <div class="col-md-6">
  </div>
  <div class="col-md-6">
    <div class="form-group container">
      <table class="table table-sm">
        <tr>
          <td>Weight</td><td class="text-right"><h6><?=four_decimal($record['credit_weight'])?></h6></td>
        </tr><tr>
          <td>Rate</td><td class="text-right"><h6><?=four_decimal($record['rate'])?></h6></td>
        </tr><tr>
          <td>Taxable Amount</td><td class="text-right"><h6><?=four_decimal($record['taxable_amount'])?></h6></td>
        </tr><tr>
          <td>CGST Amount (<?= $gst_rate ?>%)</td><td class="text-right"><h6><?=four_decimal($record['cgst_amount'])?></h6></td>
        </tr><tr>
          <td>SGST Amount (<?= $gst_rate ?>%)</td><td class="text-right"><h6><?=four_decimal($record['sgst_amount'])?></h6></td>
        </tr>
        <?php if ($record['sale_type'] != 'Labour') { ?>
          <tr>
            <td>Total Amount</td><td class="text-right"><h6><?=four_decimal(  $record['taxable_amount']
                                                                            + $record['cgst_amount']
                                                                            + $record['sgst_amount'])?></h6></td>
          </tr>
          
          <tr>
            <td>TCS</td><td class="text-right"><h6><?=four_decimal(($record['taxable_amount']
                                                                   + $record['cgst_amount']
                                                                   + $record['sgst_amount']) * .075 / 100)?></h6></td>
          </tr>
        <?php } ?>
        <tr>
          <td>Grand Total</td><td class="text-right"><h6><?=four_decimal($record['debit_amount'])?></h6></td>
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


