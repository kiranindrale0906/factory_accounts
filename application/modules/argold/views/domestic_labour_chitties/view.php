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

<style type="text/css">

  @page { 
    margin: 0mm; 
    size: 4cm 6cm ;
    size: landscape;
  }
</style>


