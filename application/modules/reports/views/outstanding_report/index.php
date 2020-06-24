<?php 
$show_heading = isset($view_type) && $view_type == 'combined_report' ? FALSE : TRUE;
if($show_heading){ ?>
  <div class="boxrow mb-2">
    <div class="float-left">
     <h6 class="heading blue bold text-uppercase mb-0"><?= @getTableSettings()['page_title']; ?></h6>
    </div>
  </div>
<?php } ?>

<div class="table-responsive m-t-20">
  <table class="table table-sm fixedthead table-default">
  <?php 
    $this->load->view('reports/outstanding_report/table_header');
    $this->load->view('reports/outstanding_report/table_body');
  ?>
  </table>
</div>
         
          
     
              
          