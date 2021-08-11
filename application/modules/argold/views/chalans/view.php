<style>
@media print {    
  .no-print, .no-print * {
    display: none !important;
  }
}
</style>
<div style="max-width: 1200px;width:100%;margin:0 auto">
<div class="row mb-3 ">
  <div class="col-md-3 ">
   <h4 style="margin-left:45%" class="heading ">Chalan No #<?= $record['id']; ?></h4>
  </div>
  <div class="col-md-9 text-right">
</div>
<div style="">

  <?php $this->load->view('chalan_details/viewlist') ;
  ?>
<div style="max-width:45%; margin-left:10%; page-break-after:avoid">
  <table class="table table-sm">
    <tr>
      <td>Weight</td><td class="text-right"><h6><?=four_decimal($record['weight'])?></h6></td>
    </tr>
    <tr class="no-print">
      <td class="no-print">Taxable Amount</td>
      <td class="text-right no-print"><h6><?=four_decimal($record['taxable_amount'])?></h6></td>
    </tr>
    <tr class="no-print">
      <td class="no-print">CGST Amount</td>
      <td class="text-right no-print"><?=four_decimal($record['cgst_amount'])?></td>
    </tr>
    <tr class="no-print">
      <td class="no-print">SGST Amount</td>
      <td class="text-right no-print"><?=four_decimal($record['sgst_amount'])?></td>
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


