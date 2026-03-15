<style>
@media print {    
  .no-print, .no-print * {
    display: none !important;
  }
}
</style>
<div class="row ">
  <div class="col-md-6 ">
  <?php if(empty($_GET['tag'])){ ?>
   <h4 style="margin-left:45%" class="heading ">Domestic Labour Chitti No #<?= $record['id']; ?></h4>
  <?php } ?>
  </div>
  <div class="col-md-6 text-right">
  <a  href="<?=ADMIN_PATH.'argold/domestic_labour_chitties/edit/'. $record['id']?>" class='btn bg_blue white no-print'>create metal receipt</a>
  <button class="btn btn-primary btn-sm d-print-none" id="btn_print" onclick="window.print()" data-title="Print this page"><i class="fas fa-print"></i> Print</button></div>

</div>
<div style="max-width:60%; margin-left:10%">
  <?php $this->load->view('domestic_labour_chitti_details/viewlist') ?>
</div>
<div style="max-width:45%; margin-left:10%; page-break-after:avoid">
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
      <td class="no-print">CGST Amount (<?= 2.5 ?>%)</td>
      <td class="text-right no-print"><?=four_decimal($record['cgst_amount'])?></td>
    </tr>
    <tr class="no-print">
      <td class="no-print">SGST Amount (<?= 2.5 ?>%)</td>
      <td class="text-right no-print"><?=four_decimal($record['sgst_amount'])?></td>
    </tr>
    
      <tr class="no-print">
        <td class="no-print">Total Amount</td>
        <td class="text-right no-print"><?=four_decimal(  $record['taxable_amount']
                                                                        + $record['cgst_amount']
                                                                        + $record['sgst_amount'])?></td>
      </tr>
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


