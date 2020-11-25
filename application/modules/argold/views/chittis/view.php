<h4 class="heading ml-3">Chitti #<?= $record['id']; ?></h4>

<div style="max-width:30%;">
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


<div style="max-width:30%">
  <?php $this->load->view('chitti_details/viewlist'); ?>
</div>

<?php 
  if ($record['sale_type'] == 'Labour')
    $gst_rate = 2.5;
  else
    $gst_rate = 1.5;
?>

<div style="max-width:30%">
  <table class="table table-sm">
    <tr>
      <td>Weight</td><td class="text-right"><h6><?=four_decimal($record['credit_weight'])?></h6></td>
    </tr><tr>
      <td>Rate</td><td class="text-right"><h6><?=four_decimal($record['rate'])?></h6></td>
    </tr>
    <div class="noprint">
      <tr class="noprint">
        <td class="noprint">Taxable Amount</td>
        <td class="text-right norprint"><h6 class="noprint"><?=four_decimal($record['taxable_amount'])?></h6></td>
      </tr>
      <tr class="noprint">
        <td class="noprint">CGST Amount (<?= $gst_rate ?>%)</td>
        <td class="text-right noprint"><?=four_decimal($record['cgst_amount'])?></td>
      </tr>
      <tr class="noprint">
        <td class="noprint">SGST Amount (<?= $gst_rate ?>%)</td>
        <td class="text-right noprint"><?=four_decimal($record['sgst_amount'])?></td>
      </tr>
      <?php if ($record['sale_type'] != 'Labour') { ?>
        <tr class="noprint">
          <td class="noprint">Total Amount</td>
          <td class="text-right noprint"><?=four_decimal(  $record['taxable_amount']
                                                                          + $record['cgst_amount']
                                                                          + $record['sgst_amount'])?></td>
        </tr>
        
        <tr class="noprint">
          <td class="noprint">TCS</td><td class="text-right noprint"><?=four_decimal(($record['taxable_amount']
                                                                 + $record['cgst_amount']
                                                                 + $record['sgst_amount']) * .075 / 100)?></td>
        </tr>
      <?php } ?>
    </div>
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


