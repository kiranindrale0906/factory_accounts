<h4 class="heading noprint ml-3">Chitti #<?= $record['id']; ?></h4>

<div class="col-md-4">
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
<div class="col-md-8">
</div>


<div class="col-md-4">
  <?php $this->load->view('chitti_details/viewlist'); ?>
</div>

<?php 
  if ($record['sale_type'] == 'Labour')
    $gst_rate = 2.5;
  else
    $gst_rate = 1.5;
?>

<div class="col-md-4">
  <table class="table table-sm">
    <tr>
      <td>Weight</td><td class="text-right"><h6><?=four_decimal($record['credit_weight'])?></h6></td>
    </tr><tr>
      <td>Rate</td><td class="text-right"><h6><?=four_decimal($record['rate'])?></h6></td>
    </tr><tr>
      <td>Taxable Amount</td><td class="text-right"><h6><?=four_decimal($record['taxable_amount'])?></h6></td>
    </tr><tr>
      <td>CGST Amount (<?= $gst_rate ?>%)</td><td class="text-right"><?=four_decimal($record['cgst_amount'])?></td>
    </tr><tr>
      <td>SGST Amount (<?= $gst_rate ?>%)</td><td class="text-right"><?=four_decimal($record['sgst_amount'])?></td>
    </tr>
    <?php if ($record['sale_type'] != 'Labour') { ?>
      <tr>
        <td>Total Amount</td><td class="text-right"><?=four_decimal(  $record['taxable_amount']
                                                                        + $record['cgst_amount']
                                                                        + $record['sgst_amount'])?></td>
      </tr>
      
      <tr>
        <td>TCS</td><td class="text-right"><?=four_decimal(($record['taxable_amount']
                                                               + $record['cgst_amount']
                                                               + $record['sgst_amount']) * .075 / 100)?></td>
      </tr>
    <?php } ?>
    <tr>
      <td>Grand Total</td><td class="text-right"><h6><?=four_decimal($record['debit_amount'])?></h6></td>
    </tr>
  </table>
</div>
<div class="col-md-8">
</div>

<style type="text/css">

  @page { 
    margin: 0mm; 
    size: 4cm 6cm ;
    size: landscape;
  }
</style>


