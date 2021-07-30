<style>
@media print {    
  .no-print, .no-print * {
    display: none !important;
  }
}
</style>
<div style="max-width: 1200px;width:100%;margin:0 auto">
<div class="row mb-3 ">
  <div class="col-md-6 ">
  <?php if(empty($_GET['tag'])){ ?>
   <h4 style="margin-left:45%" class="heading ">Packing Slip No #<?= $record['id']; ?></h4>
  <?php } ?>
  </div>
  <div class="col-md-6 text-right">
  <a  href="<?=ADMIN_PATH.'argold/packing_slips/edit/'. $record['id']?>" class='btn bg_blue white no-print'>create metal receipt</a>
  
  <a  href="<?=ADMIN_PATH.'argold/packing_slips/view/'. $record['id'].'?tag=1'?>" class='btn bg_blue white no-print'>Tagging</a>
  
  <button class="btn btn-primary btn-sm d-print-none" id="btn_print" onclick="window.print()" data-title="Print this page"><i class="fas fa-print"></i> Print</button></div>

</div>
<div style="">

  <?php !empty($_GET['tag']) ?$this->load->view('packing_slip_details/taglist'):$this->load->view('packing_slip_details/viewlist') ?>
</div>
</div>

<style type="text/css">

  @page { 
    margin: 0mm; 
    size: 4cm 6cm ;
    size: landscape;
  }
</style>


