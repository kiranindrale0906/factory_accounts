<?php 
  $this->load->view('reports/production_summary/search', array('url' => ADMIN_PATH."reports/production_summary/index"));
?>

<h5 class="heading blue m-0">Production Summary</h5>
<?php 
  foreach($groups as $index => $group) { ?>
    <div class="row">
      <div class="col-md-6 border-right">
        <div class="table-responsive m-t-20">
          <h5>Production <?= $group ?></h5>
          <table class="table table-sm fixedthead">
            <?php $this->load->view('reports/production_summary/thead'); ?>
              <?php 
                if (isset($production_details[$group])) {
                  foreach($production_details[$group]['records'] as $record) {
                    $this->load->view('reports/production_summary/tbody', array('record' => $record));
                  }
                }
                $this->load->view('reports/production_summary/total', array('group' => $group));
                $this->load->view('reports/production_summary/balance', array('group' => $group));
              ?>
          </table>
        </div> 
      </div>
      <div class="col-md-6 border-right">
        <div class="table-responsive m-t-20">
          <h5>Refresh <?= $group ?></h5>
          <table class="table table-sm fixedthead">
            <?php 
              $this->load->view('reports/refresh_summary/thead'); 
              $total = $vadotar = 0;
              if (isset($refresh_details[$group])) {
                foreach($refresh_details[$group]['records'] as $record) {
                  $this->load->view('reports/refresh_summary/tbody', array('record' => $record));
                }
              }
              $this->load->view('reports/refresh_summary/total', array('group' => $group));
            ?>
          </table>
        </div> 
      </div>
    </div>
  <?php } 
?>
      
