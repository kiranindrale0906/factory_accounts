<div class="row">
  <div class="col-md-3">
    <div class="form-group container">
      <table class="table table-sm fixedthead table-default">
        <?php 
          $arf_arc_vadotar = 0;
          foreach ($company_vadotars as $company_name => $vadotar) { 
            $arf_arc_vadotar = $arf_arc_vadotar + $vadotar ?>
            <tr>
              <td><b><?= $company_name; ?></b></td>
              <td class="text-right"><?= four_decimal($vadotar, '-') ?></td>
            </tr>
          <?php } 
        ?>
        <tr>
          <td><b>AR Gold</b></td>
          <td class="text-right"><?= four_decimal($total_vadotar['vodator'] - $arf_arc_vadotar, '-') ?></td>
        </tr>
        <tr>
          <td><b>Total</b></td>
          <td class="text-right"><?= four_decimal($total_vadotar['vodator'], '-') ?></td>
        </tr>
    </div>
  </div>
</div>