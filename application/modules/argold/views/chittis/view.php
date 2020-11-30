<style>
@media print {    
  .no-print, .no-print * {
    display: none !important;
  }
}
</style>
<h4 class="heading ml-3">Chitti #<?= $record['id']; ?></h4>

<div style="max-width:40%;">
  <table class="table table-sm">
    <tr>
      <td><h6><?=$chittis_details['account_name']?></h6></td><td class="text-right"><h6><?=date('d-m-Y',strtotime($record['created_at']))?></h6></td>
    </tr><tr>
      <td>Sale Type</td><td class="text-right"><h6><?= $record['sale_type'] ?></h6></td>
    </tr>
    <?php if (empty($record['no_of_packets'])) { ?>
      <tr>
        <td>No of Packets</td><td class="text-right"><h6><?=round($record['no_of_packets'])?></h6></td>
      </tr>
    <?php } ?>
    <?php if (empty($record['packet_gross_weight'])) { ?>
      <tr>
        <td>Packet Gross Weight</td><td class="text-right"><h6><?=four_decimal($record['packet_gross_weight'])?></h6></td>
      </tr>
    <?php } ?>
  </table>
</div>

<div style="max-width:40%">
  <?php $this->load->view('chitti_details/viewlist'); ?>
</div>

<?php 
  if ($record['sale_type'] == 'Labour')
    $gst_rate = 2.5;
  else
    $gst_rate = 1.5;
?>

<div style="max-width:40%">
  <table class="table table-sm">
    <tr>
      <td>Weight</td><td class="text-right"><h6><?=four_decimal($record['credit_weight'])?></h6></td>
    </tr><tr>
      <td>Rate</td><td class="text-right"><h6><?=four_decimal($record['rate'])?></h6></td>
    </tr>

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
    <?php if ($record['sale_type'] != 'Labour') { ?>
      <tr class="no-print">
        <td class="no-print">Total Amount</td>
        <td class="text-right no-print"><?=four_decimal(  $record['taxable_amount']
                                                                        + $record['cgst_amount']
                                                                        + $record['sgst_amount'])?></td>
      </tr>
      
      <tr class="no-print">
        <td class="no-print">TCS</td>
        <td class="text-right no-print"><?=four_decimal(($record['taxable_amount']
                                                               + $record['cgst_amount']
                                                               + $record['sgst_amount']) * .075 / 100)?></td>
      </tr>
    <?php } ?>
 
    <tr>
      <td>Grand Total</td><td class="text-right"><h6><?=four_decimal($record['debit_amount'])?></h6></td>
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


