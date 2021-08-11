<style>
@media print {    
  .no-print, .no-print * {
    display: none !important;
  }
}
</style>
<div class="row ">
  <div class="col-md-3">
   <h4 style="margin-left:45%" class="heading">Chalan No #<?= $record['id']; ?></h4>
  </div>
  <div class="col-md-8 text-right">
  </div>
  <div class="col-md-1 text-right">
  
  </div>
</div>

<div style="max-width:45%; margin-left:10%">
  <table class="table table-sm">
    <tr><td>Date</td><td class="text-right"><h6><?= date('d-m-Y',strtotime($record['date']))?></h6></td>
    </tr>
  </table>
</div>

<div style="max-width:45%; margin-left:10%">
  <?php $this->load->view('chalan_details/viewlist'); ?>
</div>

<?php 
  if (!empty($record['sale_type'])&&$record['sale_type'] == 'Labour')
    $gst_rate = 2.5;
  else
    $gst_rate = 1.5;
?>

<div style="max-width:45%; margin-left:10%; page-break-after:avoid">
  <table class="table table-sm">
    <tr>
      <td>Weight</td><td class="text-right"><h6><?=four_decimal($record['credit_weight'])?></h6></td>
    </tr><!-- <tr>
      <td>Rate</td><td class="text-right"><h6><?//=four_decimal($record['rate'])?></h6></td>
    </tr> -->
    <tr class="no-print">
      <td class="no-print">Taxable Amount</td>
      <td class="text-right no-print"><h6><?=four_decimal($record['taxable_amount'])?></h6></td>
    </tr>
   
    <tr class="no-print">
      <td class="no-print">CGST Amount (<?= $gst_rate ?>%)</td>
      <td class="text-right no-print"><?=four_decimal($record['cgst_amount'])?></td>
    </tr>
    <tr class="no-print">
      <td class="no-print">SGST Amount (<?= $gst_rate ?>%)</td>
      <td class="text-right no-print"><?=four_decimal($record['sgst_amount'])?></td>
    </tr>
    <tr>
      <td>Grand Total</td><td class="text-right"><h6><?=four_decimal($record['sgst_amount']+$record['cgst_amount']+$record['taxable_amount'])?></h6></td>
    </tr>
  </table>
</div>

<style type="text/css">

  @page { 
    margin: 0mm; 
    size: 4cm 6cm ;
    size: landscape;
  }
</style>


