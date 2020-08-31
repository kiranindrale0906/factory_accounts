<?php 
  $this->load->view('reports/production_summary/search', array('url' => ADMIN_PATH."reports/production_summary/index"));
?>
<div class="col-md-6 border-right">
  <div class="form-group container">
    <div class="table-responsive m-t-20">
      <h5 class="heading blue m-0">Production Summary</h5>
      <?php 
        foreach($records['data'] as $group => $record_data) { ?>
          <h5><?= $group ?></h5>
          <table class="table table-sm fixedthead">
            <?php $this->load->view('reports/production_summary/thead'); ?>
              <?php 
                $total = $vadotar = 0;
                foreach($records['data'][$group]['records'] as $record) {
                  $total += $record['issue_gpc_out'];
                  $vadotar += $record['issue_gpc_out'] * ($record['out_purity'] - $record['in_purity']) / 100;
                  $this->load->view('reports/production_summary/tbody', array('record' => $record));
                }
                $this->load->view('reports/production_summary/total', array('total' => $total, 'vadotar' => $vadotar));
              ?>
          </table>
        <?php } ?>
    </div> 
  </div>
</div>
      
