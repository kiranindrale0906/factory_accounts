<?php 
  $this->load->view('reports/production_same_purity_summary/search', array('url' => ADMIN_PATH."reports/production_same_purity_summary/index"));
?>

<h5 class="heading blue m-0">Production Summary</h5>
<?php 
  foreach($groups as $index => $group) { ?>
    <div class="row">
      <div class="col-md-12 border-right">
        <div class="table-responsive m-t-20">
          <h5>Production <?= $group ?></h5>
          <table class="table table-sm fixedthead">
            <?php $this->load->view('reports/production_same_purity_summary/thead'); ?>
              <?php 
                if (isset($production_details[$group])) {
                  foreach($production_details[$group]['records'] as $record) {
                    if(four_decimal($record['in_purity'])==four_decimal($record['out_purity'])){
                    $this->load->view('reports/production_same_purity_summary/tbody', array('record' => $record));
                    }
                  }
                }
                $this->load->view('reports/production_same_purity_summary/total', array('group' => $group));
                $this->load->view('reports/production_same_purity_summary/balance', array('group' => $group));
              ?>
          </table>
        </div> 
      </div>
    </div>
  <?php } 
?>
      
