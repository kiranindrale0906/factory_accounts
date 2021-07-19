<style>
@media print {    
  .no-print, .no-print * {
    display: none !important;
  }
}
</style>
<div class="row ">
  <div class="col-md-3">
   <h4 style="margin-left:45%" class="heading">Packing Slip No #<?= $record['id']; ?></h4>
  </div>

</div>

<div style="max-width:45%; margin-left:10%">
  <table class="table table-sm">
    <tr>
      <td><h6><?=$chittis_details['account_name']?></h6></td><td class="text-right"><h6><?= date('d-m-Y',strtotime($record['date']))?></h6></td>
    </tr><tr>
      <td> Quantity</td><td class="text-right"><h6><?= $record['quantity'] ?></h6></td>
    </tr>
    <tr>
      <td> Gross Weight</td><td class="text-right"><h6><?= $record['weight'] ?></h6></td>
    </tr>
    <tr>
      <td> Net Weight</td><td class="text-right"><h6><?= $record['net_weight'] ?></h6></td>
    </tr>
    <tr>
      <td> Stone</td><td class="text-right"><h6><?= $record['stone'] ?></h6></td>
    </tr>
    <tr>
      <td> Purity</td><td class="text-right"><h6><?= $record['purity'] ?></h6></td>
    </tr>
    <tr>
      <td> Pure</td><td class="text-right"><h6><?= $record['pure'] ?></h6></td>
    </tr> <tr>
      <td> Making Charge</td><td class="text-right"><h6><?= $record['making_charge'] ?></h6></td>
    </tr> <tr>
      <td> Total</td><td class="text-right"><h6><?= $record['total'] ?></h6></td>
    </tr>
         
    
  </table>
</div>

<div style="max-width:45%; margin-left:10%">
  <?php $this->load->view('packing_slip_details/viewlist'); ?>
</div>

<style type="text/css">

  @page { 
    margin: 0mm; 
    size: 4cm 6cm ;
    size: landscape;
  }
</style>


